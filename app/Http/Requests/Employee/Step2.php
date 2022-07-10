<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Step2 extends FormRequest
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
            'site_id' => 'required',
            'site_id.*' => 'required|exists:user_sites,id',
            'position_id' => 'required',
            'position_id.*' => 'required|exists:user_positions,id',
            'roster_start_time' => 'required|integer|max:7|min:1',
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
