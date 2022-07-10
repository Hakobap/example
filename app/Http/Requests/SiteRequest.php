<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SiteRequest extends FormRequest
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
            'id' => 'nullable|exists:user_sites,id',
            'country_id' => 'required|exists:countries,id',
            'value' => 'required|string|max:100|min:2',
            'address' => 'required|string|max:100|min:2',
            'state' => 'required|string|max:100|min:2',
            'postcode' => 'required|integer|max:99999999|min:2',
            'city' => 'required|string|max:50|min:2',
            'phone' => ['required', new PhoneNumber()],
        ];
    }
}
