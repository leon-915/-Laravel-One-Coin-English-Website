<?php

namespace App\Http\Requests\Student\PostJob;

use Illuminate\Foundation\Http\FormRequest;

class PostJobRequest extends FormRequest
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
            'subject' => 'required',
            'price' => 'required|numeric',
            'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'Please enter subject',
            'price.required' => 'Please enter price',
            'price.numeric' => 'Price must be in numbers',
            'description.required' => 'Please enter highlights',
        ];
    }
}
