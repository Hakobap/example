<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class HowItWorksRequest extends FormRequest
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
            'file' => 'mimes:jpeg,jpg,png,gif',
            'title' => 'required|max:10000|min:2',
            'text' => 'required|max:10000|min:2',
            'extra' => 'required|integer|max:100000000000|min:0',
        ];
    }

    public function messages()
    {
        return [
            'text.min' => 'The description must be at least 2 characters.',
            'text.max' => 'The description may not be greater than 10000 characters.',
            'title.min' => 'The title must be at least 2 characters.',
            'title.max' => 'The title may not be greater than 10000 characters.',
            'extra.integer' => 'The Sort Number must be an integer.',
            'extra.min' => 'The Sort Number must be at least 0.',
            'extra.max' => 'The Sort Number may not be greater than 100000000000.',
        ];
    }
}
