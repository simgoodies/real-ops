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
            'start_time' => 'required',
            'end_time' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A name for the event is required',
            'name.max' => 'A name can consist of a maximum of 100 characters',
            'description.required' => 'A description for the event is required',
            'start_time.required' => 'Please enter a start time in ZULU / UTC time zone',
            'end_time.required' => 'Please enter an end time in ZULU / UTC time zone'
        ];
    }
}
