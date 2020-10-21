<?php

namespace App\Http\Requests\Admin\StaticPages;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
    public function rules() {
        $page_id = $this->route()->parameters()['static_page'];
        return [
            'page_name' => 'required|unique:static_pages,page_name,'.$page_id,
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
