<?php

namespace App\Http\Requests\Admin\OnePageLevel;

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
            'name' => 'required|max:255',
            'description_en' => 'required',
            'description_ja' => 'required',
            'status' => 'required',
        ];
        return $array_rule;
    }

    public function messages()
    {
        return [
            'name.required' => 'Please Enter Level Name',
            'description_en.required' => 'Please Enter Description_en',
            'description_ja.required' => 'Please Enter Description_ja',
            'status.required'  => 'Please Select Status',
        ];
    }
}
