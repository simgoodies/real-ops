<?php

namespace App\Http\Requests\Tenants\Bookings;

use Illuminate\Foundation\Http\FormRequest;

class StoreCancellationRequest extends FormRequest
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
            'email' => 'required|email',
        ];
    }

    /**
     * Error messages for the validator.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'An email address is required',
            'email.email' => 'A valid email address has to be provided',
        ];
    }
}
