<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class HomeTextsRequest extends FormRequest
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
            'home_text1' => 'required|max:10000|min:2',
            'home_text2' => 'required|max:10000|min:2',
            'home_text3' => 'required|max:10000|min:2', // faq title
            'home_text4' => 'required|max:10000|min:2', // faq description
            'home_text5' => 'required|max:10000|min:2',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
