<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmployeeToDoListStatusRequest extends FormRequest
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
            'done' => 'array',
            'done.*' => 'exists:to_do_lists,id,employee_id,' . Auth::id(),
            'pending' => 'array',
            'pending.*' => 'exists:to_do_lists,id,employee_id,' . Auth::id(),
        ];
    }
}
