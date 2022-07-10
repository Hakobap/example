<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Step5 extends FormRequest
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
        return [
            'value1' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'value2' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'value3' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'value4' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'value5' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'value6' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'value7' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'public_holidays' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        ];
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
