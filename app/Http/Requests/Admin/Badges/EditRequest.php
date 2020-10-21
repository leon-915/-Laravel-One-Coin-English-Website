<?php

namespace App\Http\Requests\Admin\Badges;

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
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ];
        return $array_rule;
    }
    public function messages()
    {
        return [
            'title.required'=>'Please Enter Title',
            'description.required'=>'Please Enter Description',
            'status.required'=>'Please Select Status',
        ];
    }
}
