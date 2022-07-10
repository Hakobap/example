<?php

namespace App\Http\Controllers\Employee;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Models\EmployeeAction;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard(Request $request)
    {
        $modelActions = new EmployeeAction();

        $employeeActions = $modelActions->with('site', 'position')->where('user_id', Auth::id())->get();

        $positions = $employeeActions->pluck('position.value', 'position.id');

        $sites = $employeeActions->pluck('site.value', 'site.id');

        $employee = Auth::user();

        $employeeTasks = Task::where(['user_id' => $employee->parent_id, 'employee_id' => $employee->id])->get();

        if ($site_id = intval($request->get('site', 0))) {
            $employeeSites = [$site_id];
        } else {
            $employeeSites = $employeeTasks->pluck('site_id', 'site_id')->toArray();
        }

        $site_id = array_values($employeeSites)[0] ?? 0;

        $employees = Employee::where('parent_id', $employee->parent_id)
            ->with(['tasks', 'employeeActions'])
            ->whereHas('employeeActions', function ($query) use ($employeeSites) {
                $query->whereIn('user_site_id', $employeeSites);
            })->get();

        $taskModel = new Task();

        $calendar_schedule = 6;
        $task_id = 0;
        $taskById = $taskModel;


        if ($request->ajax()) {
            $calendar_schedule = intval($request->post('calendar_schedule', 6));

            $task_id = intval($request->post('task_id', 0));

            $taskById = $taskModel
                ->with(['employeeAction' => function ($query) use ($site_id) {
                    $query->with('position');
                    $query->where('user_site_id', $site_id);
                }])
                ->where('id', $task_id)
                ->first() ?: $taskModel;
        }

        return view(
            $request->ajax() ? 'employee.task-management.schedule-table' : 'employee.dashboard',
            compact('sites', 'positions', 'employee', 'employees', 'site_id', 'calendar_schedule', 'task_id', 'taskById')
        );
    }
}
