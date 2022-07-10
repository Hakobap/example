<?php

namespace App\Services;

use App\Services\Traits\WeekCalendar;
use Carbon\Carbon;

class Calendar
{
    use WeekCalendar;

    protected $date;

    protected $week = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];

    protected $calendar = [];

    protected $actions = [];

    public static $filterInterval = [
        6 => 'Week',
        13 => '2 Week',
        27 => '4 Week',
        29 => 'Month',
        30 => 'Month',
    ];

    public function __construct($date = null)
    {
        $this->date = str_replace('/', '-', $date ? $date : request()->get('week_date', Carbon::now()->format('Y-m-d')));
        $this->date = Carbon::parse($this->date)->format('y-m-d h:i:s');
    }

    public function getCalendar()
    {
        $this->calendar['actions'] = $this->actions;

        return $this->calendar;
    }

    public static function getFilterIntervalName($days)
    {
        return self::$filterInterval[$days] ?? $days . ' Days';
    }

    public function getTodayNumber()
    {
        return array_flip($this->week)[Carbon::now()->dayName];
    }

    public function getTodayName()
    {
       return $this->getNameByDay($this->getTodayNumber());
    }

    public function getNameByDay($day)
    {
        if (empty($this->calendar)) {
            $this->setWeekNameFromDay();
        }

        if (!isset($this->calendar[$day])) {
            $arr = $this->calendar;
            $arr2 = array_keys($this->calendar);
            if (isset($calendar['action'])) {
                unset($arr['action']);
                $lastDayNum = end($arr2);
                $diff = $lastDayNum - $day;
                return Carbon::parse($this->date)->addDays($diff)->dayName;
            }
        }

        return $this->calendar[$day];
    }

    public function getDaysInMonth()
    {
        return Carbon::parse($this->date)->daysInMonth;
    }

    public function setWeekNameFromDay()
    {
        $n = 0;
        for ($i = 0; $i <= $this->getDaysInMonth(); $i++) {
            if ($n == 6) {
                $n = 0;
            }
            $this->calendar[$i] = $this->week[$n];
            $n++;
        }
    }

    public function setActionOnDay($day, $action)
    {
        if (isset($this->calendar[$day])) {
            $this->actions[$day] = $action;
        }

        return $this;
    }

    public function isBusyDay($day)
    {
        return isset($this->actions[$day]) && $this->actions[$day];
    }
}