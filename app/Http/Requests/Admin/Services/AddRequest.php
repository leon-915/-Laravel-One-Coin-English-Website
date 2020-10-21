<?php

namespace App\Http\Requests\Admin\Services;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $array_rule = [
            'title' => 'required|max:255',
//            'description' => 'required',
            'length' => 'required|numeric',
            'padding_minutes' => 'required|numeric',
//            'price' => 'required|numeric',
  //          'receive_credit_on_booking' => 'required|numeric',
            'service_name_en' => 'required',
//            'prepayment' => 'numeric',
//            'available_lessons' => 'required|numeric',
//            'location_id' => 'required',
//            'package_id' => 'required',
//            'teacher_id' => 'required',
            'status' => 'required',
        ];
        return $array_rule;
    }

    public function messages()
    {
        return [
//            'title.required' => '',
//            'title.max' => '',
//            'description.required' => '',
//            'length.required' => '',
//            'length.numeric' => '',
//            'padding_minutes.required' => '',
//            'padding_minutes.numeric' => '',
//            'price.required' => '',
//            'price.numeric' => '',
//            'receive_credit_on_booking.required' => '',
//            'receive_credit_on_booking.numeric' => '',
//            'service_name_en.required' => '',
//            'prepayment.numeric' => '',
//            'available_lessons.required' => '',
//            'available_lessons.numeric' => '',
//            'location_id.required' => '',
//            'package_id.required' => '',
//            'teacher_id.required' => '',
//            'status.required'  => 'Please Select Status',
        ];
    }
}
