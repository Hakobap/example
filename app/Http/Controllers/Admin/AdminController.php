<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\View;
use App\Models\ChangePassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    use View;

    /**
     * Show the application dashboard page.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return $this->view('dashboard', 'admin');
    }

    /**
     * Change password page.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $model = $this->changePasswordModel();
        $model->user = Auth::user();

        if ($request->isMethod('post'))  {
            $validator = $model->validation($request);
            if ($model->change($validator, $request)) {
                //redirect('/admin/change-password');
            }
        }

        return $this->view('change-password', 'admin/settings');
    }

    public function changePasswordModel()
    {
        return new ChangePassword();
    }

    public function profile()
    {
        $user = array_filter(Auth::user()->getAttributes(), function($k) {
            return !array_keys(['email_verified_at', 'password', 'remember_token'], $k);
        }, ARRAY_FILTER_USE_KEY);

        return view('admin.settings.profile', [
            'user' => $user,
        ]);
    }
}