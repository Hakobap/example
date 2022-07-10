<?php

namespace App\Http\Controllers\User;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\CopyShiftRequest;
use App\Http\Requests\ScheduleRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\toDoListRequest;
use App\Http\Requests\ToDoListStatusRequest;
use App\Http\Requests\ToDoListUpdateRequest;
use App\Models\EmployeeAction;
use App\Models\Task;
use App\Models\ToDoList;
use App\Services\Calendar;
use App\ToDoListAttachment;
use App\User;
use App\UserPosition;
use App\UserSite;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TaskManagementController extends Controller
{
    /**
     * @var Task
     */
    protected $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function add()
    {
        $userGroup = auth()->user()->children->pluck('id', 'id');
        $userGroup[] = auth()->id();
        $positions = UserPosition::whereIn('user_id', $userGroup)->groupBy('value')->get();
        $employees = User::where('parent_id', auth()->id())->get();

        return view('user.task-management.add', compact('positions', 'employees'));
    }

    public function delete($id)
    {
        Task::where(['id' => $id, 'user_id' => auth()->id()])->firstOrFail()->delete();

        return back();
    }

    public function store($id = null, TaskRequest $request)
    {
        if (!$this->validateTask($request)) {
            return back();
        }

        $this->model->fill(array_merge($request->all(), ['user_id' => auth()->id()]))->save();

        return redirect(route('user.staff'));
    }

    public function validateTask($request)
    {
        $posUid = UserPosition::findOrFail($request->position_id)->user_id;

        $checker1 = true;
        if ($posUid != auth()->id()) {
            $checker1 = User::findOrFail($posUid)->parent_id == auth()->id();
        }

        $checker2 = User::findOrFail($request->employee_id)->parent_id == auth()->id();

        return $checker1 && $checker2;
    }

    // Schedule Actions

    public function roster()
    {
        $sites = UserSite::where('user_id', auth()->id())->get();

        if (isset($sites[0]->id)) {
            return redirect(route('user.task-management.schedule', $sites[0]->id));
        }

        // TODO this action bellow temporary is disabled

        return view('user.task-management.roster', compact('sites'));
    }

    /**
     * @param Request $request
     * @return int
     */
    public function getCalendarSchedule($request)
    {
        $calendar_schedule = intval($request->post('calendar_schedule', $request->get('view', 6)));

        if ($calendar_schedule < 6) {
            $calendar_schedule = 6;
        }

        if ($calendar_schedule > 30) {
            $calendar_schedule = 30;
        }

        return $calendar_schedule;
    }

    public function schedule($id, Request $request)
    {
        $site_id = intval(request('site', $id));
        $employee_id = intval(request('employee', 0));
        $ctype = intval(request('ctype', 0));
        $publish = intval($request->post('publish', 0));
        $task_id = 0;
        $calendar_schedule = $this->getCalendarSchedule($request);
        $taskById = $this->model;

        $siteSelected = UserSite::findOrFail($site_id);
        $employeeSelected = Employee::find($employee_id);

        $employeesQuery = User::where('parent_id', auth()->id())
            ->with(['tasks', 'employeeActions'])
            ->whereHas('employeeActions', function ($query) use ($site_id) {
                $query->where(['employee_actions.user_site_id' => $site_id]);
            });

        // Publish changed or deleted(by employee) shifts
        if (in_array($publish, [1, 2])) {
            $this->model->publishShifts($employeesQuery, $publish, $site_id, $calendar_schedule, true);
        }

        // tasks count by params
        $publishedCount = $this->model->getTasksCount($employeesQuery, $site_id, $calendar_schedule, 1, 0);
        $unpublishedCount = $this->model->getTasksCount($employeesQuery, $site_id, $calendar_schedule, 0, 0);
        $trashedCount = $this->model->getTasksCount($employeesQuery, $site_id, $calendar_schedule, null, 1);

        // the employee employees for this shift
        $shiftEmployees = $employeesQuery->get();

        if ($employee_id) {
            $employeesQuery->where('id', $employee_id);
        }

        // filtered employees
        $employees = $employeesQuery->get();

        if ($request->ajax()) {
            // copy and past shift action by schedule interval
            if (in_array($ctype, [1, 2])) {
                $this->model->copyShift($request, $employeesQuery, $site_id, $calendar_schedule);
            }

            // getting the edit task modal data
            $task_id = intval($request->post('task_id', 0));
            $taskById = $this->model
                ->with(['employeeAction' => function ($query) use ($site_id) {
                    $query->with('position');
                    $query->where('user_site_id', $site_id);
                }])
                ->where('id', $task_id)
                ->first() ?: $this->model;
            // end
        }

        return view(
            $request->ajax() ? 'user.task-management.schedule-table' : 'user.task-management.schedule',
            compact(
                'site_id', 'siteSelected', 'employeeSelected', 'employees', 'shiftEmployees', 'calendar_schedule',
                'task_id', 'taskById', 'employee_id', 'publishedCount', 'unpublishedCount', 'trashedCount'
            )
        );
    }

    public function scheduleStore($id = null, ScheduleRequest $request)
    {
        $success = false;

        $this->model = $this->model->find(intval($id)) ?: $this->model;

        DB::beginTransaction();

        try {
            if ($this->validateTask($request)) {
                $calendar = new Calendar($request->week_date);

                $data = $request->all();

                $data['user_id'] = auth()->user()->parent_id ?: auth()->id(); // combining ids for both user and employee actions
                $data['start_date'] = $calendar->getStartDate()->addDays($request->row - 1)->format('Y-m-d ') . $data['start_date'] . ':00';
                $data['end_date'] = $calendar->getStartDate()->addDays($request->row - 1)->format('Y-m-d ') . $data['end_date'] . ':00';
                $data['publish'] = 0;

                $success = $this->model->fill($data)->save();

                if ($success) {
                    $calendar_schedule = $this->getCalendarSchedule($request);

                    $this->model->scheduleInfoNotifyEmployee($this->model->employee, $calendar_schedule);
                }

                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();

            $success = false;
        }

        return ['success' => $success];
    }

    public function scheduleDelete($id)
    {
        $userId = auth()->id();

        Task::where(['user_id' => $userId, 'id' => $id])->firstOrFail()->delete();
    }

    public function employeePositions(Request $request)
    {
        $positions = EmployeeAction::getPositions($request->id, $request->site_id);

        return $positions->count() ? ['success' => true, 'data' => $positions] : ['success' => false];
    }

    public function copyShift(CopyShiftRequest $request)
    {
        $calendar = new Calendar();

        $this->model = $this->model->findOrFail($request->task_id);

        $attributes = $this->model->getAttributes();

        if ($success = $this->checkEmpAccessForShift($request->employee_id)) {
            $attributes['employee_id'] = $request->employee_id;
            $attributes['start_date'] = $calendar->getStartDate()->addDays(($request->row - 1))->format('Y-m-d ') . Carbon::parse($attributes['start_date'])->format('H:i') . ':00';
            $attributes['end_date'] = $calendar->getStartDate()->addDays(($request->row - 1))->format('Y-m-d ') . Carbon::parse($attributes['end_date'])->format('H:i') . ':00';

            $success = (new Task())->fill($attributes)->save();
        }

        return ['success' => $success];
    }

    public function checkEmpAccessForShift($employee_id)
    {
        return (bool)EmployeeAction::where(['user_site_id' => $this->model->site_id, 'user_id' => $employee_id])->count();
    }


    #####################  User Tasks (to-do list) actions  #####################


    public function tasks(Request $request)
    {
        $employees = User::where('parent_id', auth()->id())->where('id', '!=', auth()->id())->get();

        $employersIncompleteCount = $employeesIncompleteCount = 0;

        $employer_tasks = ToDoList::searchEmployers($request, $employersIncompleteCount);

        $employee_tasks = ToDoList::searchEmployees($request, $employeesIncompleteCount);

        $sitesForEmployees = auth()->user()->sites;

        $siteSelected = UserSite::find(intval($request->site_id));

        $employeeSelected = Employee::find(intval($request->employee_id));

        return view(
            'user.task-management.to-do-list.to-do-list',
            compact(
                'employees', 'employer_tasks', 'employee_tasks', 'employersIncompleteCount', 'employeesIncompleteCount',
                'sitesForEmployees', 'employer_tasks', 'siteSelected', 'employeeSelected'
            )
        );
    }

    public function getTask($id)
    {
        $task = ToDoList::where(['user_id' => auth()->id(), 'id' => $id])->firstOrFail();

        return ['success' => true, 'data' => $task];
    }

    public function taskDelete($id)
    {
        $success = ToDoList::where(['id' => $id, 'user_id' => auth()->id()])->firstOrFail()->delete();

        return ['success' => $success];
    }

    public function taskStore(toDoListRequest $request)
    {
        $model = ToDoList::where(['id' => $request->id, 'user_id' => auth()->id()])->first() ?: new ToDoList();

        $success = $model->fill(array_merge($request->all(), ['user_id' => auth()->id()]))->save();

        return ['success' => $success];
    }

    public function taskUpdateStatus(ToDoListStatusRequest $request)
    {
        if (is_array($request->done) && !empty($request->done)) {
            DB::table('to_do_lists')->whereIn('id', $request->done)->update(['status' => 2]);
        }

        if (is_array($request->pending) && !empty($request->pending)) {
            DB::table('to_do_lists')->whereIn('id', $request->pending)->update(['status' => 0]);
        }

        return ['success' => true];
    }

    /**
     * Attache the request file and save form to DB
     *
     * @param ToDoListUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function taskUpdate(ToDoListUpdateRequest $request)
    {
        $id = array_keys($request->file('file'))[0];
        $file = array_values($request->file('file'))[0];

        $model = ToDoList::where('id', $id)->whereIn('user_id', [Auth::id(), Auth::user()->parent_id])->firstOrFail();

        $fileOriginEx = $file->getClientOriginalExtension();
        $fileOriginFullName = $file->getClientOriginalName();
        $fileOriginName = str_replace('.' . $fileOriginEx, '', $fileOriginFullName);
        $fileName = $fileOriginFullName;

        if (is_file(public_path('attachments/' . Auth::id()) . DIRECTORY_SEPARATOR . $fileName)) {
            $fileName = $fileOriginName . ' - copy(' . Carbon::now()->format('d m Y H:i:s') . ').' . $fileOriginEx;
        }

        $isMoved = $file->move(public_path('attachments/' . Auth::id()), $fileName);

        if ($isMoved) {
            (new ToDoListAttachment)->fill(['to_do_list_id' => $model->id, 'file' => $fileName, 'user_id' => Auth::id()])->save();
        }

        return back()->with(['success' => 'The file was attached successfully!']);
    }

    public function getAttachments($attachment_id, $to_do_list_id)
    {
        $model = ToDoList::where('id', $to_do_list_id)->orWhere(['user_id' => Auth::id(), 'employee_id' => Auth::id()])->firstOrFail();

        $attachmentModel = ToDoListAttachment::where('id', $attachment_id)->where('to_do_list_id', $to_do_list_id)->orWhere([
            ['user_id', '=', Auth::id()],
            ['user_id', '=', $model->employee_id]
        ])->firstOrFail();

        $attachment1 = public_path('attachments/' . Auth::id() . DIRECTORY_SEPARATOR . $attachmentModel->file);
        $attachment2 = public_path('attachments/' . Auth::id() . DIRECTORY_SEPARATOR . $attachmentModel->file);

        return [$attachment1, $attachment2, $attachmentModel];
    }

    public function downloadAttachment($attachment_id, $to_do_list_id)
    {
        list($attachment1, $attachment2) = $this->getAttachments($attachment_id, $to_do_list_id);

        try {
            $response = Response::download($attachment1);
        } catch (\Exception $e) {
            try {
                $response = Response::download($attachment2);
            } catch (\Exception $e) {
                $response = back();
            }
        }

        return $response;
    }

    public function trashAttachment($attachment_id, $to_do_list_id)
    {
        list($attachment1, $attachment2, $attachmentModel) = $this->getAttachments($attachment_id, $to_do_list_id);

        if (is_file($attachment1)) {
            unlink($attachment1);
        }

        if (is_file($attachment2)) {
            unlink($attachment2);
        }

        return ['success' => $attachmentModel->delete()];
    }
}
