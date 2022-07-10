<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Step4Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:150|min:2',
            'last_name' => 'required|max:150|min:2',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', new PhoneNumber()],
            'site' => 'required',
            'site.*' => 'required|distinct|max:150|min:2',
            'position' => 'required',
            'position.*' => 'required|distinct|max:150|min:2',
            //'phone_prefix' => 'required|integer|min:0|max:10000',
            //'company' => 'required|max:10000|min:2',
            //'password' => 'required|max:25|min:6',
            //'roster_start_time' => 'required|integer|max:7|min:1',
        ];
    }
}
