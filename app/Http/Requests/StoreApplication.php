<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplication extends FormRequest
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
            'fir_name' => 'required|max:100',
            'contact_first_name' => 'required|max:100',
            'contact_last_name' => 'required|max:100',
            'contact_email' => 'required|email|max:100',
            'vatsim_id' => 'required|numeric|digits_between:6,7',
            'icao' => 'required|size:4',
            'motivation' => 'required'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'fir_name.required' => 'A FIR / ARTCC name is required',
            'fir_name.max' => 'A FIR / ARTCC can have a maximum of 100 characters',
            'contact_first_name.required' => 'A first name is required',
            'contact_first_name.max' => 'A first name can have a maximum of 100 characters',
            'contact_last_name.required' => 'A first name is required',
            'contact_last_name.max' => 'A last name can have a maximum of 100 characters',
            'contact_email.required' => 'A contact email address is required',
            'contact_email.email' => 'Please enter a valid email address',
            'contact_email.max' => 'A contact email can have a maximum of 100 characters',
            'vatsim_id.required' => 'A VATSIM ID is required',
            'vatsim_id.numeric' => 'A VATSIM ID can only consist of digits',
            'vatsim_id.digits_between' => 'A VATSIM ID can only consist of 6 to 7 digits',
            'icao.required' => 'Please enter a valid ICAO format region identifier. For example TJZS for San Juan FIR',
            'icao.size' => 'Please enter a valid ICAO format region identifier. For example TJZS for San Juan FIR',
            'motivation.required' => 'Please briefly let us know what your motivation for applying is.'
        ];
    }
}
