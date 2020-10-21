<?php
namespace App\Http\Requests\Teacher\Profile;

use Illuminate\Foundation\Http\FormRequest;

class SaveInfoRequest extends FormRequest
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
        $rules = [
            'profile_image' => 'mimes:jpeg,png,jpg',
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
            //'audio_attachment' => 'mimes:mp3,mp4',
            //'attachments' => 'mimes:jpeg,png,jpg,doc,pdf,docx,zip,csv',
            'nationality' => 'required',
        ];

        return $rules;
           
    }

    public function messages() {
        $msgs = [
            'profile_image.required' => 'The profile image field is required.',
            'profile_image.mimes' => 'The format of profile image must jpg/jpeg/png.',
            'firstname.required' => 'The firstname field is required.',
            'firstname.max' => 'Firstname should be less than 60 characters',
            'lastname.required' => 'The lastname field is required.',
            'lastname.max' => 'Lastname should be less than 60 characters',
            'audio_attachment.mimes' => 'The format of audio attachment must mp3/mp4 .',
            'nationality.required' => 'The nationality field is required.',
        ];

        return $msgs;
    }
}
