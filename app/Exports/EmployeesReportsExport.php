<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeesReportsExport implements FromCollection
{
    protected static $data = [
        [
            'Employee', 'Wage Cost', 'Time Tracking', 'Staff Availability', 'On Shift', 'Job Tasks Assigned',
            'Job Tasks Completed', 'Leave', 'Onboarding Data'
        ]
    ];

    public static function add(array $data)
    {
        self::$data[] = $data;
    }

    /**
     * EmployeesReportsExport constructor.
     *
     * @param Employee[] $employees
     */
    public function __construct($employees)
    {
        if (!$employees->count()) return;

        foreach ($employees as $employee) {
            self::add([
                $employee->first_name . ' ' . $employee->last_name,
                '-----',
                '-----',
                $employee->getStaffAvailability()->count(),
                count($employee->employeeOnShiftSites()),
                $employee->toDoList()->count(),
                $employee->toDoListCompleted()->count(),
                '?????',
                '?????'
            ]);
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect(self::$data);
    }
}
