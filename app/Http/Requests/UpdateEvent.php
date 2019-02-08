<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvent extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date',
            'end_time' => 'required',
            'banner_image_link' => 'nullable|url'
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
            'description.required' => 'A description for the event is required',
            'start_date.required' => 'Please enter the start date of the event!',
            'start_date.date' => 'Please enter a valid event start date',
            'start_time.required' => 'Please enter a start time in ZULU / UTC time zone',
            'end_date.required' => 'Please enter the end date of the event!',
            'end_date.date' => 'Please enter a valid event end date',
            'end_time.required' => 'Please enter a end time in ZULU / UTC time zone',
            'banner_image_link.url' => 'Please enter a valid url for the event banner'
        ];
    }
}
