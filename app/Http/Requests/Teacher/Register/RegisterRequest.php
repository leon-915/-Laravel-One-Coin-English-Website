<?php
namespace App\Http\Requests\Teacher\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
       /* $maxGlobal = $this->max_global;
        $maxCafe = $this->max_cafe;
        $maxClass = $this->max_classroom;
        $maxVirtual = $this->max_virtual;*/

        $rules = [
            /*'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',*/
            'email' => 'required|email|unique:users,email',
        ];
        return $rules;           
    }

    public function messages() {
        $msgs = [
            /*'firstname.required' => 'The firstname field is required.',
            'firstname.max' => 'Firstname should be less than 60 characters',
            'lastname.required' => 'The lastname field is required.',
            'lastname.max' => 'Lastname should be less than 60 characters',*/
            'email.required' => 'The email field is required.',
        ];
        return $msgs;
    }
}
