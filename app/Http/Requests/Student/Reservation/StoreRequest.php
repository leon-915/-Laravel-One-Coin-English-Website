<?php

namespace App\Http\Requests\Student\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'teacher' => 'required',
            'location' => 'required',
            'reserve_date' => 'required',
            'time' => 'required',
            //'location_details' => 'required',
            'service' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'teacher.required' => 'Please select subject',
            'location.required' => 'Please select location',
            'reserve_date.required' => 'Please select reserve date',
            'time.required' => 'Please select time',
           // 'location_details.required' => 'Please enter location details',
            'service.required' => 'Please select service',
        ];
    }
}
