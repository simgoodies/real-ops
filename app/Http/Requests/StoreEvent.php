<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
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
            'description' => 'required',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date',
            'end_time' => 'required'
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
            'name.required' => 'A name for the event is required',
            'name.max' => 'A name can consist of a maximum of 100 characters',
            'description.required' => 'A description for the event is required',
            'start_date.required' => 'Please enter the start date of the event!',
            'start_date.date' => 'Please enter a valid event start date',
            'start_time.required' => 'Please enter a start time in ZULU / UTC time zone',
            'end_date.required' => 'Please enter the end date of the event!',
            'end_date.date' => 'Please enter a valid event end date',
            'end_time.required' => 'Please enter a end time in ZULU / UTC time zone',
        ];
    }
}
