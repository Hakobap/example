<?php

namespace App\Http\Requests\Employee;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Step1 extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    public static function getRules()
    {
        $data = [

        ];

        if (request()->segment(4)) {
            $data['email'] = 'required|email|unique:users,email,' . request()->segment(4);
            $data['password'] = 'nullable|max:25|min:6';
        }

        $data = array_merge([
            'first_name' => 'required|max:100|min:2',
            'last_name' => 'required|max:100|min:2',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', new PhoneNumber()],
            'password' => 'required|max:25|min:6',
        ], $data);

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return self::getRules();
    }
}
