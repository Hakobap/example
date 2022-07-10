<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ScheduleRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user_id = Auth::user()->parent_id ?: Auth::id();

        return [
            'site_id' => 'required|exists:user_sites,id,user_id,' . $user_id,
            'position_id' => 'required|exists:user_positions,id,user_id,' . $user_id,
            'employee_id' => 'required|exists:users,id',
            //'hours' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            //'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'area' => 'required|string|min:3|max:1000',
            'description' => 'nullable|string|min:3|max:1000',
            'start_date' => 'required|date_format:H:i',
            'end_date' => 'required|date_format:H:i',
            'row' => 'required|integer|min:1|max:30',
        ];
    }

    public function messages()
    {
        return [
            'position_id.required' => 'The position field is required.',
            'position_id.exist' => 'The position not found.',
            'description.required' => 'The Task Information field is required.',
            'description.min' => 'The Task Information must be at least 3 characters.',
            'description.max' => 'The Task Information may not be greater than 1000 characters.',
        ];
    }
}
