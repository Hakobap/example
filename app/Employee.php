<?php

namespace App;

use App\Models\EmployeeAction;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class Employee extends User
{
    public $newRecord;

    protected $table = 'users';

    protected $fillable = [
        'first_name', 'last_name', 'company', 'roster_start_time', 'phone', 'email', 'password',
        'photo', 'address', 'city', 'country_id', 'post_code', 'emergency_control_name', 'emergency_phone',
        'gender', 'date_of_birth', 'hired_date'
    ];

    public function checkSite($id)
    {
        return EmployeeAction::where(['user_id' => $this->id, 'user_site_id' => $id])->count();
    }

    public function checkPosition($id)
    {
        return EmployeeAction::where(['user_id' => $this->id, 'user_position_id' => $id])->count();
    }

    public function deletePhoto()
    {
        if (!$this->newRecord && $this->photo && is_file(public_path('images/user/' . $this->photo))) {
            unlink(public_path('images/user/' . $this->photo));
        }
    }

    public function getEmployerTaskIds()
    {
        $taskIds = Task::where('user_id', Auth::id())->pluck('employee_id', 'employee_id')->toArray();

        return $taskIds;
    }

    public function getRosters($check_date = true)
    {
        $query = self::where('parent_id', Auth::id());

        if ($check_date == true) {
            $query->whereDoesntHave('tasksFromRequest');

        }

        $rosters = $query->get();

        return $rosters;
    }

    public function getStaffAvailability($params = [])
    {
        $query = $this->where('parent_id', auth()->id())
            ->where('users.id', '!=', auth()->id())
            ->with([
                'employeeActions' => function ($query) {
                    $query->with('site');
                },
                'tasksFromRequest' => function ($query) use ($params) {
                    $query->with('site')->whereHas('site');
                }
            ]);

        if (isset($params['site_id'])) {
            $query->whereHas('employeeActions', function ($query) use ($params) {
                $query->where('user_site_id', $params['site_id']);
            });
            // TODO  The code bellow helps get employees which has available tasks linked
//            $query->whereHas('tasksFromRequest', function ($query) use ($params) {
//                $query->where('site_id', $params['site_id']);
//            });
        }

        return $query->get();
    }

    public function employeesSites()
    {
        $query = $this->employeeActions->pluck('site.value', 'site.id');

        return $query->toArray();
    }

    public function employeeOnShiftSites()
    {
        $query = $this->tasksFromRequest->pluck('site.value', 'site.id');

        return $query->toArray();
    }
}
