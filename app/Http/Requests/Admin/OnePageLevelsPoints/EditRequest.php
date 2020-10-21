<?php

namespace App\Http\Requests\Admin\OnePageLevelsPoints;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{public function authorize()
{
    return true;
}

    public function rules()
    {
        $array_rule = [
            'level_id' => 'required',
            'rating_point' => 'required',
            'description_en' => 'required',
            'description_ja' => 'required',
            'status' => 'required',
        ];
        return $array_rule;
    }

    public function messages()
    {
        return [
            'level_id.required' => 'Please Select Level',
            'rating_point.required' => 'Please Select Rating Point',
            'description_en.required' => 'Please Enter Description_en',
            'description_ja.required' => 'Please Enter Description_ja',
            'status.required'  => 'Please Select Status',
        ];
    }
}
