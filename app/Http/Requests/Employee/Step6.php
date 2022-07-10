<?php

namespace App\Http\Requests\Employee;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Step6 extends FormRequest
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
            'gender' => 'required|integer|max:1|min:0',
            'date_of_birth' => 'nullable|date|before:' . Carbon::now()->addYears('-18')->format('Y-m-d'),
            'hired_date' => 'nullable|date',
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
