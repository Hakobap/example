<?php

namespace App\Http\Controllers\User;

use App\Employee;
use App\Exports\EmployeesReportsExport;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OnboardingController extends Controller
{
    /**
     * Reports page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $employees = $this->getEmployees($request);

        return view('user.onboarding.index', compact('employees'));
    }


    /**
     * Export employee's reports
     *
     * @return \Illuminate\Support\Collection
     */
    public function exportReports(Request $request)
    {
        $employees = $this->getEmployees($request);

        return Excel::download(new EmployeesReportsExport($employees), Carbon::now()->format('d m Y H:i:s') . ' - reports.xlsx');
    }

    /////////// Bellow Extra functions for onboarding controller ///////////

    public function getEmployees(Request $request)
    {
        $employee_id = intval($request->get('employee_id'));

        $query = Employee::with(['tasks' => function ($query) {
            // updating query by request date
            Employee::tasksFromRequestQuery($query);
        }])->where('parent_id', auth()->id());

        if ($employee_id) {
            $query->where('id', $employee_id);
        }

        $employees = $query->get();

        return $employees;
    }

    public function getEmployeeTasks($employee_id)
    {
        $query = Task::where('user_id', auth()->id())->orderBy('employee_id');

        // updating query by request date
        Employee::tasksFromRequestQuery($query);

        if ($employee_id) {
            $query->where('employee_id', $employee_id);
        }

        $tasks = $query->get();

        return $tasks;
    }
}
