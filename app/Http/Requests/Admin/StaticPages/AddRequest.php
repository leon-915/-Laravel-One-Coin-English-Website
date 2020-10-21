<?php

namespace App\Http\Requests\Admin\StaticPages;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'page_name' => 'required|unique:static_pages,page_name',
            'title' => 'required',
            'meta_keyword' => 'required',
            'meta_description' => 'required',
            'body' => 'required'
        ];
    }

    public function messages()
    {
        return [
           
        ];
    }
}
