<?php

namespace App\Http\Requests\Tenants\Office;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFlight extends FormRequest
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
            'callsign' => [
                'required',
                'alpha_num',
                'max:10',
                Rule::unique('tenant.flights')->where(function ($query) {
                    return $query->where('event_id', request()->get('event_id'));
                }),
            ],
            'pilot_id' => 'exists:pilots,id',
            'origin_airport_icao' => 'required|exists:system.airports,icao',
            'destination_airport_icao' => 'required|exists:system.airports,icao',
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
            'callsign.required' => 'A callsign is required, for example AAL123',
            'callsign.alpha_num' => 'A callsign may only consist of letters and digits, for example AAL123',
            'callsign.max' => 'A callsign can consist of a maximum of 10 characters',
            'callsign.unique' => 'The provided callsign is already in use',
            'pilot_id.exists' => 'The pilot must exist',
            'origin_airport_icao.required' => 'The origin airport is required, for example TJSJ',
            'origin_airport_icao.exists' => 'Please enter a valid origin airport ICAO, for example TJSJ',
            'destination_airport_icao.required' => 'The destination airport can consist only of letters, for example TNCM',
            'destination_airport_icao.exists' => 'Please enter a valid destination airport ICAO, for example TNCM',
            'departure_time.required' => 'The departure time is required',
            'arrival_time.required' => 'The arrival time is required',
            'aircraft_type_icao.max' => 'The aircraft type can have a maximum of four characters, for example B734',
            'aircraft_type_icao.alpha_num' => 'The aircraft type may only consist of letters and digits, for example B734',
        ];
    }
}
