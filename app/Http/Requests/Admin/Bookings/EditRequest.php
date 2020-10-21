<?php

namespace App\Http\Requests\Admin\Bookings;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $array_rule = [
            'service_id' => 'required',
            'teacher_id' => 'required',
            'location_id' => 'required',
            'user_id' => 'required',
            'lession_date' => 'required',
            'time' => 'required',
           /* 'lesson_duration' => 'required',*/
        ];
        return $array_rule;
    }
    public function messages()
    {
        return [
            'service_id.required' => 'Please Select Service',
            'teacher_id.required' => 'Please Select Teacher',
            'location_id.required' => 'Please Select Location',
            'user_id.required' => 'Please Enter Student Name',
            'lession_date.required' => 'Please select date',
            'time.required' => 'Please Select Lession Time',
           /* 'lesson_duration.required' => 'Please Select Lession Duration',*/
        ];
    }
}
