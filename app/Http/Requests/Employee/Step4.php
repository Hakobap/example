<?php

namespace App\Http\Requests\Employee;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Step4 extends FormRequest
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
            'address' => 'nullable|max:100|min:2',
            'city' => 'nullable|max:50|min:2',
            'country_id' => 'nullable|exists:countries,id',
            'post_code' => 'nullable|integer|max:99999999|min:2',
            'emergency_control_name' => 'nullable|max:100|min:2',
            'emergency_phone' => ['nullable', new PhoneNumber()],
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
