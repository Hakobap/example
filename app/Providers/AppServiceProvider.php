<?php

namespace App\Providers;

use App\Services\Calendar;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using Closure based composers...
        View::composer('*', function ($view) {
            if (auth()->check()) {
                try {
                    $calendar = new Calendar(request()->get('week_date'));
                } catch(\Exception $e) {
                    $calendar = new Calendar();
                }

                $calendarDayStart = $calendar->getStartDate()->format('d/m/Y');
                $calendarDayEnd = $calendar->getStartDate()->addDays(6)->format('d/m/Y');

                $usersGlobal = User::where('id', auth()->id())->orWhere('parent_id', auth()->id())->get();
                $employeesGlobal = User::where('parent_id', auth()->id())->get();

                $view->with(compact('usersGlobal', 'employeesGlobal', 'calendar', 'calendarDayStart', 'calendarDayEnd'));
            }
        });
    }
}
