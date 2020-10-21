<?php

namespace App\Http\Requests\Admin\LocationType;

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
    public function rules()
    {
        $array_rule = [
            'title' => 'required|max:255',
            'status' => 'required',
        ];
        return $array_rule;
    }

    public function messages()
    {
        return [
            'status.required'  => 'Please Select Status',
        ];
    }
}
