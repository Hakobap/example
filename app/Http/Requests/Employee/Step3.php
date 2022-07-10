<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Step3 extends FormRequest
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
        if (request()->segment(4)) {
            $data = [
                'photo' => 'nullable|mimes:jpeg,jpg,png|max:100000',
            ];
        } else {
            $data = [
                'photo' => 'required|mimes:jpeg,jpg,png|max:100000',
            ];
        }

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
