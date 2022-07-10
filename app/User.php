<?php

namespace App;

use App\Models\EmployeeAction;
use App\Models\PayRate;
use App\Models\Roles;
use App\Models\Task;
use App\Models\ToDoList;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $taskDate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'parent_id', 'email_verified_at', 'created_at', 'updated_at', 'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roleById()
    {
        return $this->hasOne(Roles::class, 'user_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'employee_id', 'id');
    }

    public function toDoList()
    {
        return $this->hasOne(ToDoList::class, 'employee_id', 'id');
    }

    public function toDoListCompleted()
    {
        return $this->hasOne(ToDoList::class, 'employee_id', 'id')->where('status', 2);
    }

    public function tasksAvailable()
    {
        return $this->tasks()->where('end_date', '>=', Carbon::now());
    }

    /**
     * Getting task by request date.
     * The interval when is positive then getting available tasks for those interval
     *
     * @note the interval value will be equal "interval + 1 day" -> 24:59:59 @see the code bellow
     *
     * @param Builder $query
     * @param int $interval
     * @return Builder
     */
    public static function tasksFromRequestQuery(&$query, $interval = 0)
    {
        $dateFrom = Task::getCalendarFromRequest()->getStartDate()->toDateString();

        $dateTo = Carbon::parse($dateFrom)->addDays($interval + 1)->toDateString();

        $query->where(DB::raw('DATE(start_date)'), '>=', $dateFrom)->where(DB::raw('DATE(end_date)'), '<', $dateTo);

        return $query;
    }

    public function tasksFromRequest()
    {
        $query = $this->hasMany(Task::class, 'employee_id', 'id');

        $this->tasksFromRequestQuery($query);

        return $query;
    }

    public function setTaskDate($date)
    {
        $this->taskDate = $date;

        return $this;
    }

    public function task($site_id = null)
    {
        $date = Carbon::parse($this->taskDate)->format('Y-m-d');

        $whereRaw = "(DATE(tasks.start_date)='$date' or DATE(tasks.end_date)='$date') and employee_id=" . $this->id;

        if ($site_id) {
            $whereRaw .= ' and site_id=' . intval($site_id);
        }

        return Task::whereRaw($whereRaw);
    }

    public function tasksCalculated()
    {
        $tasks = $this->tasksAvailable;
        $payRate = $this->payRate;
        $result = new \stdClass();
        $result->hours = 0;
        $result->price = 0;

        if ($payRate && $tasks) {
            $result->hours = $tasks->sum('hours');

            foreach ($tasks as $task) {
                $dayOfWeek = Carbon::parse($task->start_date)->dayOfWeek;
                $result->price += $payRate->{'value' . $dayOfWeek};
            }
        }

        $result->hours = number_format((float)$result->hours, 2, '.', '');;
        $result->price = number_format((float)($result->hours * $result->price), 2, '.', '');;

        return $result;
    }

    public function taskCalculated()
    {
        $task = $this->task;
        $payRate = $this->payRate;
        $result = new \stdClass();
        $result->hours = 0;
        $result->price = 0;

        if ($payRate && $task) {
            $dayOfWeek = Carbon::parse($task->start_date)->dayOfWeek;
            $result->hours = $task->hours;
            $result->price = $payRate->{'value' . $dayOfWeek};
        }

        $result->hours = number_format((float)$result->hours, 2, '.', '');;
        $result->price = number_format((float)($result->hours * $result->price), 2, '.', '');;

        return $result;
    }

    ////////// We Can Take The User All Employees's Sites And Positions (By The Site And Position Relations)

    public function sites()
    {
        return $this->hasMany(UserSite::class, 'user_id', 'id');
    }

    public function positions()
    {
        return $this->hasMany(UserPosition::class, 'user_id', 'id');
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    public function employeeActions()
    {
        return $this->hasMany(EmployeeAction::class, 'user_id', 'id');
    }

    public function positionsGrouped()
    {
        return $this->hasMany(EmployeeAction::class, 'user_id', 'id')->groupBy('employee_actions.user_position_id');
    }

    public function sitesGrouped()
    {
        return $this->hasMany(EmployeeAction::class, 'user_id', 'id')->groupBy('employee_actions.user_site_id');
    }

    public function payRate()
    {
        return $this->hasOne(PayRate::class, 'user_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id', 'id');
    }

    public static function positionsFormModel($model)
    {
        $result = [];
        foreach ($model as $attributes) {
            $result[] = $attributes->value;
        }
    }
}
