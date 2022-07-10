<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TaskRequest extends FormRequest
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
        return [
            'position_id' => 'required|exists:user_positions,id',
            'employee_id' => 'required|exists:users,id',
            'hours' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'required|string|min:3|max:1000',
            'start_date' => 'required|date_format:Y-m-d\TH:i|after:yesterday',
            'end_date' => 'required|date_format:Y-m-d\TH:i|after:yesterday',
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
