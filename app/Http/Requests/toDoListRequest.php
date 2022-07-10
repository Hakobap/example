<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class toDoListRequest extends FormRequest
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
            'site_id' => 'nullable|exists:user_sites,id',
            'employee_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string|min:3|max:1000',
            'title' => 'required|string|min:3|max:1000',
            'due_date' => 'nullable|date|after:yesterday',
        ];
    }

    public function messages()
    {
        return [
            'description.min' => 'The Task Information must be at least 3 characters.',
            'description.max' => 'The Task Information may not be greater than 1000 characters.',
        ];
    }
}
