<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAirline extends FormRequest
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
            'name' => 'required|max:100',
            'callsign' => 'alpha|max:30',
            'icao' => 'required|alpha|max:3'
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
            'name.required' => 'A name for the airline is required',
            'name.max' => 'A name can consist of a maximum of 100 characters',
            'callsign.alpha' => 'A callsign can only consist of alphabetic characters',
            'callsign.max' => 'A callsign can consist of a maximum of 30 characters',
            'icao.required' => 'An ICAO code for the airline is required',
            'icao.alpha' => 'An ICAO code can only consist of alphabetic characters',
            'icao.max' => 'An ICAO code can consist of a maximum of 3 characters'
        ];
    }
}
