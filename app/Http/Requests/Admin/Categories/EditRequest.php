<?php

namespace App\Http\Requests\Admin\Categories;

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
            'title_en' => 'required|max:300',
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
