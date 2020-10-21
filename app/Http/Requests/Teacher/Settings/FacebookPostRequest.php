<?php
namespace App\Http\Requests\Teacher\Settings;

use Illuminate\Foundation\Http\FormRequest;

class FacebookPostRequest extends FormRequest
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

        return [
            'subject' => 'required|max:191',
            'message' => 'required|max:1000',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];
        return $rules;  
    }

    public function messages() {
        $msgs = [
            'subject.required' => 'Subject field is required.',
            'subject.max' => 'Subject should be less than 191 characters',
            'message.required' => 'Message field is required.',
            'message.max' => 'Message should be less than 1000 characters',
            'image.max' => 'Image size should be less than 2MB.',
            'image.image' => 'Attachment must be an image.',
            'image.mimes' => 'Attachment must have jpeg/jpg/png extention.',
        ];

        return $msgs;
        
    }
}
