<?php

namespace App\Services\Traits;

use Carbon\Carbon;

trait WeekCalendar {
    public function getStartDate()
    {
        $today = $this->getTodayNumber();
//        dd(Carbon::parse($this->date));
//        $this->date=null;
        try {
            return $this->date ? Carbon::parse($this->date) : Carbon::now()->addDays('-' . $today);
        } catch(\Exception $e) {
            return Carbon::now()->addDays('-' . $today);
        }
    }
}