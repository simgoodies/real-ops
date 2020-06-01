<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookableFlight extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'origin_airport_icao' => 'required|alpha_num|between:3,4',
            'destination_airport_icao' => 'required|alpha_num|between:3,4',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
        ];
    }
}
