<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\User\TaskManagementController as EmployerTaskManagementController;
use App\Http\Requests\EmployeeToDoListStatusRequest;
use App\Http\Requests\toDoListRequest;
use App\Models\Task;
use App\Models\ToDoList;
use App\User;
use App\UserPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskManagementController extends EmployerTaskManagementController
{
    public function tasks(Request $request)
    {
        $employersIncompleteCount = 0;

        $tasks = ToDoList::searchEmployers($request, $employersIncompleteCount, Auth::user()->parent_id);

        $employer = User::where('id', Auth::user()->parent_id)->with('sites')->first();

        $sitesForEmployees = $employer->sites;

        return view(
            'employee.task-management.to-do-list.to-do-list',
            compact('tasks', 'sitesForEmployees')
        );
    }

    public function getTask($id)
    {
        $task = ToDoList::where(['user_id' => Auth::user()->parent_id, 'employee_id' => Auth::id(), 'id' => $id])->firstOrFail();

        return ['success' => true, 'data' => $task];
    }

    public function taskDelete($id)
    {
        $success = ToDoList::where(['user_id' => Auth::user()->parent_id, 'employee_id' => Auth::id(), 'id' => $id])->firstOrFail()->delete();

        return ['success' => $success];
    }

    public function taskStore(toDoListRequest $request)
    {
        $model = ToDoList::where(['user_id' => Auth::user()->parent_id, 'employee_id' => Auth::id(), 'id' => $request->id])->first() ?: new ToDoList();

        $success = $model->fill(array_merge($request->all(), ['user_id' => Auth::user()->parent_id, 'employee_id' => Auth::id()]))->save();

        return ['success' => $success];
    }

    public function EmployeeTaskUpdateStatus(EmployeeToDoListStatusRequest $request)
    {
        if (is_array($request->done) && !empty($request->done)) {
            DB::table('to_do_lists')->whereIn('id', $request->done)->update(['status' => 2]);
        }

        if (is_array($request->pending) && !empty($request->pending)) {
            DB::table('to_do_lists')->whereIn('id', $request->pending)->update(['status' => 0]);
        }

        return ['success' => true];
    }

    public function validateTask($request)
    {
        $posUid = UserPosition::findOrFail($request->position_id)->user_id;

        $checker1 = $posUid == auth()->user()->parent_id;

        $checker2 = $request->employee_id == auth()->id();

        return $checker1 && $checker2;
    }

    public function scheduleReject($id)
    {
        $userId = auth()->user()->parent_id;

        Task::where(['user_id' => $userId, 'id' => $id])->update(['reject' => 1]);

        return back();
    }

    public function scheduleEnable($id)
    {
        $userId = auth()->user()->parent_id;

        Task::where(['user_id' => $userId, 'id' => $id])->update(['reject' => 0]);

        return back();
    }

    public function scheduleDelete($id)
    {
        $userId = auth()->user()->parent_id;

        Task::where(['user_id' => $userId, 'id' => $id])->firstOrFail()->fill(['trash' => 1])->save();
    }
}
