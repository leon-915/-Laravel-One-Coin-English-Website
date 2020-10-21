<?php

namespace App\Http\Requests\Admin\Badges;

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
            'image' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
        return $array_rule;
    }
    public function messages()
    {
        return [
            'title.required'=>'Please Enter Title',
            'image.required'=>'Please Select Image',
            'description.required'=>'Please Enter Description',
            'status.required'=>'Please Select Status',
        ];
    }
}
