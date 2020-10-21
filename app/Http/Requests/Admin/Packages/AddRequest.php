<?php

namespace App\Http\Requests\Admin\Packages;

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
            'title' => 'required',
            'price' => 'required|numeric',
            'registration_fee' => 'required|numeric',
            'onepage_fee' => 'required|numeric',
           // 'no_of_lesson_available' => 'required|numeric',
            //'duration_of_lesson' => 'required|numeric',
            'description' => 'required',
//            'reward_point' => 'required|numeric',
            'roleover_condition' => 'required|numeric',
            'status' => 'required',
        ];
        return $array_rule;
    }

    public function messages()
    {
        return [
            'title.required' => 'Please Enter Title',
            'price.required' => 'Please Enter Price',
            'registration_fee.required' => 'Please Enter Registration Fee',
            'onepage_fee.required' => 'Please Enter OnePage Fee',
            //'no_of_lesson_available.required' => 'Please Enter No Of Lesson Available',
            //'duration_of_lesson.required' => 'Please Enter Duration Of Lesson',
            'description.required' => 'Please Enter Discription',
//            'reward_point.required' => 'Please Enter Reward Point',
            'roleover_condition.required' => 'Please Enter Roleover Condition',
            'status.required'  => 'Please Select Status',
        ];
    }
}
