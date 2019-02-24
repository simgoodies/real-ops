<?php

namespace App\Http\Requests\Tenants;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFlight extends FormRequest
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
            'event_id' => 'required|exists:tenant.events,id',
            'pilot_id' => 'exists:pilots,id',
            'origin_airport_icao' => 'required|max:4|alpha',
            'destination_airport_icao' => 'required|max:4|alpha',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'aircraft_type_icao' => 'nullable|max:4|alpha_num',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'event_id.required' => 'An event must be attached to this flight',
            'event_id.exists' => 'The attached event must exist',
            'pilot_id.exists' => 'The pilot must exist',
            'origin_airport_icao.required' => 'The origin airport is required, for example TJSJ',
            'origin_airport_icao.max' => 'The origin airport can have a maximum of four characters, for example TJSJ',
            'origin_airport_icao.alpha' => 'The origin airport can consist only of letters, for example TJSJ',
            'destination_airport_icao.required' => 'The destination airport can consist only of letters, for example TNCM',
            'destination_airport_icao.max' => 'The destination airport can consist only of letters, for example TNCM',
            'destination_airport_icao.alpha' => 'The destination airport can consist only of letters, for example TNCM',
            'departure_time.required' => 'The departure time is required',
            'arrival_time.required' => 'The arrival time is required',
            'aircraft_type_icao.max' => 'The aircraft type can have a maximum of four characters, for example B734',
            'aircraft_type_icao.alpha_num' => 'The aircraft type may only consist of letters and digits, for example B734'
        ];
    }
}
