<?php

namespace App\Http\Requests\Tenants;

use Illuminate\Foundation\Http\FormRequest;

class StoreBooking extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vatsim_id' => 'required|digits_between:6,7',
            'email' => 'required|email'
        ];
    }

    /**
     * Error messages for the validator
     *
     * @return array
     */
    public function messages()
    {
        return [
            'vatsim_id.required' => 'A VATSIM ID is required',
            'vatsim_id.digits_between' => 'A VATSIM ID can only have a length of 6 to 7 digits',
            'email.required' => 'An email address is required',
            'email.email' => 'A valid email address has to be provided'
        ];
    }
}
