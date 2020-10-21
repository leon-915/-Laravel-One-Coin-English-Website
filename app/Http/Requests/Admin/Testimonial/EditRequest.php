<?php

namespace App\Http\Requests\Admin\Testimonial;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    public function rules()
    {
        $array_rule = [
            'title' => 'required',
            //'title_slug' => 'required',
            'description_en' => 'required',
            'status' => 'required',
        ];
        return $array_rule;
    }

    public function messages()
    {
        return [
            'title.required' => 'Please Enter Title',
            //'title_slug.required' => 'Please Enter Title Slug',
            'description_en.required' => 'Please Enter Description In English',
            'status.required'  => 'Please Select Status',
        ];
    }
}
