<?php

namespace App\Http\Controllers\Employee;

use App\Employee;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyEmployeeController extends Controller
{
    /*
   |--------------------------------------------------------------------------
   | VerifyEmployee Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles authenticating users for the application and
   | redirecting them to your home screen. The controller uses a trait
   | to conveniently provide its functionality to your applications.
   |
   */

    use AuthenticatesUsers;

    private $model;

    private $remember = 0;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function index($key, Request $request)
    {
        $this->__logout($request);

        $employee = $this->model->where(['invite_key' => $key, 'verified' => 0])->first();

        if ($employee) {
            $employee->verified = 1;

            if (!$employee->save()) {
                return redirect('/');
            }
        }

        return redirect('/login');
    }

    protected function __logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
    }

    public function __login($employee_id)
    {
        $this->guard()->loginUsingId($employee_id, $this->remember);
    }
}
