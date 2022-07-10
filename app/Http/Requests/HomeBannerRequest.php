<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class HomeBannerRequest extends FormRequest
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
            'extra' => 'min:2|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'text.min' => 'The description must be at least 2 characters.',
            'text.max' => 'The description may not be greater than 10000 characters.',
            'title.min' => 'The title must be at least 2 characters.',
            'title.max' => 'The title may not be greater than 10000 characters.',
            'extra.min' => 'The Button Text must be at least 2 characters.',
            'extra.max' => 'The Button Text may not be greater than 1000 characters.',
        ];
    }
}
