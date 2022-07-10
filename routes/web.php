<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

####################### test pages  #################
if (env('APP_TEST_PAGES')) {
    Route::group(['prefix' => 'test'], function () {
        Route::any('/', 'HomeController@test')->name('site.test');
        Route::any('/front', 'HomeController@testFront')->name('site.test.front');
    });
}
####################################################

// Auth routes
Auth::routes(['register' => false]);

// Employee verification route
Route::group(['prefix' => 'employee', 'namespace' => 'Employee'], function () {
    Route::get('/accept-invite/{key}', 'VerifyEmployeeController@index')->name('employee.accept-invite.index');
});

// Guest routes
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/features', 'HomeController@features')->name('site.features');
    Route::get('/pricing', 'HomeController@index')->name('site.pricing');
    Route::get('/more', 'HomeController@index')->name('site.more');
    Route::get('/about', 'HomeController@index')->name('site.about');
    Route::get('/contact', 'HomeController@index')->name('site.contact');
    Route::get('/support', 'HomeController@index')->name('site.support');
    Route::get('/terms-and-conditions', 'HomeController@index')->name('site.terms-and-conditions');
    Route::get('/privacy-policy', 'HomeController@index')->name('site.privacy-policy');

    // Step-By-Step registration routes
    Route::group(['prefix' => 'step'], function () {
        Route::post('/1', 'StepsController@step1')->name('site.steps.1');
        Route::post('/2', 'StepsController@step2')->name('site.steps.2');
        Route::post('/3', 'StepsController@step3')->name('site.steps.3');
        Route::post('/4', 'StepsController@step4')->name('site.steps.4');
        Route::post('/5', 'StepsController@step5')->name('site.steps.5');
        Route::post('/sites', 'StepsController@sites')->name('site.steps.sites');
        Route::post('/positions', 'StepsController@positions')->name('site.steps.positions');
    });

    // Set user local time
    Route::post('/localtime/set', 'HomeController@setLocaltime')->name('site.localtime.set');
});

// Employers routes
Route::group(['middleware' => ['auth', 'employer'], 'namespace' => 'User', 'prefix' => 'user'], function () {
    Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');

    Route::get('/staff', 'UserController@staff')->name('user.staff');

    Route::get('/rostering/delete/{id}', 'EmployeeController@rosteringDelete')->name('user.rostering.delete');

    // Task Management
    Route::group(['prefix' => 'task-management'], function () {
        Route::get('/add', 'TaskManagementController@add')->name('user.task-management.add');
        Route::get('/delete/{id}', 'TaskManagementController@delete')->name('user.task-management.delete');
        Route::post('/store/{id?}', 'TaskManagementController@store')->name('user.task-management.store');

        // Tasks - to do list
        Route::group(['prefix' => 'tasks'], function () {
            Route::get('/', 'TaskManagementController@tasks')->name('user.task-management.tasks');
            Route::post('/get/{id}', 'TaskManagementController@getTask')->name('user.task-management.tasks.get');
            Route::post('/delete/{id}', 'TaskManagementController@taskDelete')->name('user.task-management.tasks.delete');
            Route::post('/store', 'TaskManagementController@taskStore')->name('user.task-management.tasks.store');
            Route::post('/update-status', 'TaskManagementController@taskUpdateStatus')->name('user.task-management.tasks.update-status');

            // Files attach|delete to task
            Route::post('/update-task', 'TaskManagementController@taskUpdate')->name('user.task-management.tasks.update-task');
            Route::get('/download-attachment/{attachment_id}/{to_do_list_id}', 'TaskManagementController@downloadAttachment')->name('user.task-management.tasks.download-attachment');
            Route::post('/trash-attachment/{attachment_id}/{to_do_list_id}', 'TaskManagementController@trashAttachment')->name('user.task-management.tasks.trash-attachment');
        });

        // Roster
        Route::get('/roster', 'TaskManagementController@roster')->name('user.task-management.roster');
        Route::post('/employee-positions', 'TaskManagementController@employeePositions')->name('user.task-management.employee-positions');

        // Schedule
        Route::group(['prefix' => 'schedule'], function () {
            Route::any('/{id}', 'TaskManagementController@schedule')->name('user.task-management.schedule')->where(['id' => "[0-9]+"]);
            Route::get('/add', 'TaskManagementController@scheduleAdd')->name('user.task-management.schedule.add');
            Route::post('/delete/{id}', 'TaskManagementController@scheduleDelete')->name('user.task-management.schedule.delete');
            Route::post('/store/{id?}', 'TaskManagementController@scheduleStore')->name('user.task-management.schedule.store');
            Route::post('/copy', 'TaskManagementController@copyShift')->name('user.task-management.schedule.store');
        });
    });

    // Onboarding
    Route::group(['prefix' => 'onboarding'], function () {
        Route::get('/', 'OnboardingController@index')->name('user.onboarding');
        Route::get('/export-reports', 'OnboardingController@exportReports')->name('user.onboarding.export-reports');
    });

    // Employee actions
    Route::group(['prefix' => 'employee'], function () {
        Route::post('/add-position', 'EmployeeController@addPosition')->name('user.employee.add-position');
        Route::post('/bulk', 'EmployeeController@bulkAction')->name('user.employee.bulk');
        Route::post('/form', 'EmployeeController@form')->name('user.employee.form');
        Route::post('/store/{id?}', 'EmployeeController@employeeStore')->name('user.employee.store');

        // Employee step-by-step validation
        Route::post('/step1/{id?}', 'EmployeeController@step1')->name('user.employee.step.1');
        Route::post('/step2/{id?}', 'EmployeeController@step2')->name('user.employee.step.2');
        Route::post('/step3/{id?}', 'EmployeeController@step3')->name('user.employee.step.3');
        Route::post('/step4/{id?}', 'EmployeeController@step4')->name('user.employee.step.4');
        Route::post('/step5/{id?}', 'EmployeeController@step5')->name('user.employee.step.5');
        Route::post('/step6/{id?}', 'EmployeeController@step6')->name('user.employee.step.6');
    });

    // Sites action
    Route::group(['prefix' => 'sites'], function () {
        Route::get('/', 'UserController@sites')->name('user.sites');
        Route::post('/get', 'UserController@getSite')->name('user.sites.get');
        Route::get('/delete/{id}', 'UserController@deleteSite')->name('user.sites.delete');
        Route::post('/store', 'UserController@storeSite')->name('user.sites.store');
    });
});

// Employees routes
Route::group(['middleware' => ['auth', 'employee'], 'namespace' => 'Employee', 'prefix' => 'employee'], function () {
    Route::any('/dashboard', 'EmployeeController@dashboard')->name('employee.dashboard');

    // Task Management
    Route::group(['prefix' => 'task-management'], function () {
        // Tasks - to do list
        Route::group(['prefix' => 'tasks'], function () {
            Route::get('/', 'TaskManagementController@tasks')->name('employee.task-management.tasks');
            Route::post('/get/{id}', 'TaskManagementController@getTask')->name('employee.task-management.tasks.get');
            Route::post('/delete/{id}', 'TaskManagementController@taskDelete')->name('employee.task-management.tasks.delete');
            Route::post('/store', 'TaskManagementController@taskStore')->name('employee.task-management.tasks.store');
            Route::post('/update-status', 'TaskManagementController@EmployeeTaskUpdateStatus')->name('employee.task-management.tasks.update-status');

            // Files attach|delete to task
            Route::post('/update-task', 'TaskManagementController@taskUpdate')->name('employee.task-management.tasks.update-task');
            Route::get('/download-attachment/{attachment_id}/{to_do_list_id}', 'TaskManagementController@downloadAttachment')->name('employee.task-management.tasks.download-attachment');
            Route::post('/trash-attachment/{attachment_id}/{to_do_list_id}', 'TaskManagementController@trashAttachment')->name('employee.task-management.tasks.trash-attachment');
        });

        // Schedule
        Route::group(['prefix' => 'schedule'], function () {
            //Route::get('/add', 'TaskManagementController@scheduleAdd')->name('employee.task-management.schedule.add');
            Route::get('/reject/{id}', 'TaskManagementController@scheduleReject')->name('employee.task-management.schedule.reject');
            Route::get('/enable/{id}', 'TaskManagementController@scheduleEnable')->name('employee.task-management.schedule.enable');
            Route::post('/delete/{id}', 'TaskManagementController@scheduleDelete')->name('employee.task-management.schedule.delete');
            Route::post('/store/{id?}', 'TaskManagementController@scheduleStore')->name('employee.task-management.schedule.store');
            Route::post('/copy', 'TaskManagementController@copyShift')->name('user.task-management.schedule.store');
        });
    });
});

// Admin routes
Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@dashboard')->name('admin.home');
    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::get('/settings', 'AdminController@dashboard')->name('admin.setting');
    Route::any('/change-password', 'AdminController@changePassword')->name('admin.change-password');
    Route::any('/profile', 'AdminController@profile')->name('admin.profile');

    Route::group(['prefix' => 'banners'], function () {
        Route::group(['prefix' => 'home'], function () {
            Route::get('/', 'BannersController@home')->name('admin.banners.home');
            Route::post('/store', 'BannersController@homeStore')->name('admin.banners.home.store');
        });
    });

    Route::group(['prefix' => 'how-it-works'], function () {
        Route::get('/', 'HowItWorksController@view')->name('admin.how-it-works.view');
        Route::get('/create', 'HowItWorksController@create')->name('admin.how-it-works.create');
        Route::get('/update/{id}', 'HowItWorksController@update')->name('admin.how-it-works.update');
        Route::post('/store/{id?}', 'HowItWorksController@store')->name('admin.how-it-works.store');
        Route::get('/delete/{id}', 'HowItWorksController@delete')->name('admin.how-it-works.delete');
    });

    Route::group(['prefix' => 'investment'], function () {
        Route::get('/', 'InvestmentsController@view')->name('admin.investment.view');
        Route::get('/create', 'InvestmentsController@create')->name('admin.investment.create');
        Route::get('/update/{id}', 'InvestmentsController@update')->name('admin.investment.update');
        Route::post('/store/{id?}', 'InvestmentsController@store')->name('admin.investment.store');
        Route::get('/delete/{id}', 'InvestmentsController@delete')->name('admin.investment.delete');
    });

    Route::group(['prefix' => 'faq'], function () {
        Route::get('/', 'FaqController@index')->name('admin.faq.index');
        Route::get('/create', 'FaqController@create')->name('admin.faq.create');
        Route::get('/update/{id}', 'FaqController@update')->name('admin.faq.update');
        Route::get('/remove/{id}', 'FaqController@remove')->name('admin.faq.remove');
        Route::post('/save/{id}', 'FaqController@save')->name('admin.faq.save');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@index')->name('admin.settings.index');
        Route::post('/index-store', 'SettingsController@indexStore')->name('admin.settings.indexStore');
        Route::post('/home-store', 'SettingsController@homeStore')->name('admin.settings.homeStore');
        Route::get('/home', 'SettingsController@home')->name('admin.settings.home');
    });

    Route::group(['prefix' => 'clients'], function () {
        Route::get('/logos', 'ClientsController@logos')->name('admin.clients.logos');
        Route::get('/additional', 'ClientsController@additional')->name('admin.clients.home');
        Route::post('/store', 'ClientsController@store')->name('admin.clients.store');
        Route::get('/delete/{id}', 'ClientsController@delete')->name('admin.clients.delete');
    });
});

Route::post('/calc-hours', function () {
    $model = new \App\Models\Task();
    echo $model->getWorkHours(request('end_date'), request('start_date'), intval(request('meal_break')));
});