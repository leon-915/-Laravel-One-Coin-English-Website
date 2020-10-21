<?php
namespace App\Http\Requests\Teacher\Register;

use Illuminate\Foundation\Http\FormRequest;

class Step2RegisterRequest extends FormRequest
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
            //'profile_pic' => 'mimes:jpeg,png,jpg',
            'image' => 'required',
			'video' => 'max:5120',
            //'courses_teach' => 'required',
        ];
        return $rules;
           
    }

    public function messages() {
        $msgs = [
            'image.required' => 'The profile image field is required.',
            //'courses_teach.required' => 'The courses field is required.'
        ];
        return $msgs;
    }
}
