<?php

namespace App\Models;

use App\Employee;
use App\Services\Calendar;
use App\User;
use App\UserSite;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Task extends Model
{
    public static $STATUS = [
        -1 => 'all',
        0 => 'pending',
        2 => 'done',
    ];

    protected $fillable = [
        'user_id', 'employee_id', 'site_id', 'employee_action_id', 'description', 'start_date', 'end_date', // 'hours'
        'meal_break', 'rest_break', 'area', 'publish', 'trash', 'reject'
    ];

    public function site()
    {
        return $this->hasOne(UserSite::class, 'id', 'site_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function employeeAction()
    {
        return $this->hasMany(EmployeeAction::class, 'user_id', 'employee_id');
    }

    public static function getTaskAvailable($startDate, $endDate)
    {
        try {
            $now = strtotime(session()->get('time_now'));
            if (!$now) return 0;

            $x1 = $now - strtotime($startDate);
            $x3 = strtotime($endDate) - strtotime($startDate);
            // $x3 = $x1 + strtotime($endDate) - $now;
            $available = $x3 > $x1 ? ((100 * $x1) / $x3) : 100;
            if ($available > 100) {
                $available = 100;
            }
        } catch (\Exception $e) {
            return 0;
        }

        return $x1 <= 0 ? 0 : ceil($available);
    }

    public function getWorkHours($end_date = null, $start_date = null, $meal_break = null)
    {
        if (!isset($this->id) && !$end_date && !$start_date && !$meal_break) return 0;

        try {
            $interval = Carbon::parse($this->end_date ?: $end_date)->diff($this->start_date ?: $start_date);
            $intervalWithMinutes = abs($this->getTotalMinutes($interval));
        } catch (\Exception $e) {
            return 0;
        }

        $meal_break = $meal_break ?: $this->meal_break;

        if ($meal_break >= $intervalWithMinutes) return 0;

        $minutes = $intervalWithMinutes - $meal_break;

        $hours = $minutes / 60;

        return number_format($hours, 2, '.', '.');
    }

    public function getTotalMinutes(\DateInterval $int)
    {
        return ($int->d * 24 * 60) + ($int->h * 60) + $int->i;
    }

    public function getTotalHours(\DateInterval $int)
    {
        return ($int->d * 24) + $int->h + $int->i / 60;
    }

    /**
     * @param Builder $emQuery
     * @param $site_id
     * @param $calendarSchedule
     * @param int|null $publish
     * @param int|null $trash
     * @param int|null $reject
     * @return $this
     */
    public function getEmployeeQuery(Builder $emQuery, $site_id, $calendarSchedule, $publish = null, $trash = null, $reject = null)
    {
        return $emQuery->with(['tasks' => function ($query) use ($calendarSchedule, $site_id, $publish, $trash, $reject) {
            $query->where('site_id', $site_id);

            if (!is_null($publish)) {
                $query->where('publish', $publish);
            }

            if (!is_null($trash)) {
                $query->where('trash', $trash);
            }

            if (!is_null($reject)) {
                $query->where('reject', $reject);
            }

            User::tasksFromRequestQuery($query, $calendarSchedule);
        }]);
    }

    /**
     * @param Builder $emQuery
     * @param $site_id
     * @param $calendarSchedule
     * @param int|null $publish
     * @param int|null $trash
     * @return int
     */
    public function getTasksCount(Builder $emQuery, $site_id, $calendarSchedule, $publish = null, $trash = null)
    {
        $employees = $this->getEmployeeQuery($emQuery, $site_id, $calendarSchedule, $publish, $trash)->get();

        $count = 0;

        foreach ($employees as $employee) {
            $count += $employee->tasks->count();
        }

        return $count;
    }

    /**
     * Copy and paste schedule actions
     *
     * @param Request $request
     * @param int $site_id
     * @param int $calendarSchedule interval for adding the duplicated data
     * @param Builder $emQuery employees query
     */
    public function copyShift(Request $request, Builder $emQuery, $site_id, $calendarSchedule = 0)
    {
        $ctype = intval($request->get('ctype', 0));

        $interval = $calendarSchedule + 1;

        $employees = $emQuery->whereHas('tasks', function ($query) use ($calendarSchedule, $site_id) {
            $query->where('site_id', $site_id);
            User::tasksFromRequestQuery($query, $calendarSchedule);
        })->get();

        if ($employees->count()) {
            foreach ($employees as $employee) {
                if ($employee->tasks->count() == 0) continue;

                if ($ctype == 1) {
                    $this->copyTasksFromTo($employee->tasks, $interval, $site_id);
                } elseif ($request->copyTo && is_array($request->copyTo)) {
                    foreach ($request->copyTo as $copyTo) {
                        if ($copyTo > 0 && $copyTo <= 5) {
                            $copyInterval = intval($copyTo) * $interval;
//                             dd('copyInterval=' . $copyInterval, 'interval='. $interval, 'copyTo=' . intval($copyTo));

                            $this->copyTasksFromTo($employee->tasks, $copyInterval, $site_id);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param self[] $tasks
     * @param int $to interval|end date
     * @param int $site_id interval|end date
     */
    public function copyTasksFromTo($tasks, $to, $site_id)
    {
        foreach ($tasks as $task) {
            $attributes = $task->attributesToArray();

            if (Carbon::parse(Carbon::parse($task->start_date)->format('Y-m-d'))->timestamp >= $this->getCalendarFromRequest()->getStartDate()->timestamp
                && $site_id == $task->site_id
            ) {
                $attributes['start_date'] = Carbon::parse($task->start_date)->addDays($to)->toDate();

                $attributes['end_date'] = Carbon::parse($task->end_date)->addDays($to)->toDate();

                $attributes['description'] = '';

                if ($this->checkTaskIsAdded($attributes) === false) {
                    (new self)->fill($attributes)->save();
                }
            }
        }
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function checkTaskIsAdded(array $attributes)
    {
        return (bool)self::query()->where([
            "user_id" => $attributes['user_id'],
            "employee_id" => $attributes['employee_id'],
            "site_id" => $attributes['site_id'],
        ])->whereBetween('start_date', [
            Carbon::parse(Carbon::parse($attributes['start_date'])->format('Y-m-d') . ' 00:00:00'),
            Carbon::parse(Carbon::parse($attributes['start_date'])->format('Y-m-d') . ' 24:59:59')
        ])->whereBetween('end_date', [
            Carbon::parse(Carbon::parse($attributes['end_date'])->format('Y-m-d') . ' 00:00:00'),
            Carbon::parse(Carbon::parse($attributes['end_date'])->format('Y-m-d') . ' 24:59:59')
        ])->count();
    }

    /**
     * @param null $date
     * @return Calendar
     */
    public static function getCalendarFromRequest($date = null)
    {
        try {
            $calendar = new Calendar($date);
        } catch (\Exception $e) {
            $calendar = new Calendar();
        }

        return $calendar;
    }

    public function getTaskStatusColor($prefix = '')
    {
        $result = "$prefix green";

        if ($this->trash) {
            $result = "$prefix red";
        } elseif(!$this->publish) {
            $result = "$prefix yellow";
        }

        return trim($result);
    }

    /**
     * @param $emQuery
     * @param $type
     * @param $site_id
     * @param $calendarSchedule
     * @param bool $notify
     */
    public function publishShifts($emQuery, $type, $site_id, $calendarSchedule, $notify = true)
    {
        if ($type == 1) {
            $employees = $this->getEmployeeQuery($emQuery, $site_id, $calendarSchedule)->get();
        } else {
            $employees = $this->getEmployeeQuery($emQuery, $site_id, $calendarSchedule, null, 1)->get();
        }

        foreach ($employees as $employee) {
            if (!$employee->tasks) return;

            if ($notify) {
               $this->scheduleInfoNotifyEmployee($employee, $calendarSchedule);
            }

            foreach ($employee->tasks as $task) {
                $task->fill(['publish' => 1, 'trash' => 0])->save();
            }
        }
    }

    /**
     * @param $employee
     * @param $calendarSchedule
     */
    public function scheduleInfoNotifyEmployee($employee, $calendarSchedule)
    {
        return;







        
        $dateFrom = Task::getCalendarFromRequest()->getStartDate()->toDateString();

        $dateTo = Carbon::parse($dateFrom)->addDays($calendarSchedule + 1)->toDateString();

        $data = ['app' => env('APP_NAME')];

        Mail::send('emails.employee.publish-shifts', $data, function ($message) use ($employee, $dateFrom, $dateTo) {
            $user = Auth::user();
            if ($parent_id = Auth::user()->parent_id) {
                $user = User::findOrFail($parent_id);
                $message->subject("Shift date $dateFrom between $dateTo");
                $message->from($employee->email, $employee->first_name . ' ' . $employee->last_name);
                $message->to($user->email);
                return;
            }

            $message->subject("Shift date $dateFrom between $dateTo");
            $message->from($user->email, $user->first_name . ' ' . $user->last_name);
            $message->to($employee->email);
        });
    }
}
