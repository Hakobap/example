<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CopyShiftRequest extends FormRequest
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
            'row' => 'required|integer|min:1|max:30',
            'task_id' => 'required|exists:tasks,id,user_id,' . $user_id,
            'employee_id' => 'required|exists:users,id',
        ];
    }
}
