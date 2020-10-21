<?php

namespace App\Http\Requests\Admin\Teachers;

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
    public function rules() {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            //'name' => 'required|max:60',
            'dob' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'same:password',
            'email' => 'required|email|unique:users,email',
            'status' => 'required',
            /*'state' => 'required',
            'zipcode' => 'required'*/
        ];
    }

    public function messages() {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'Name should be less than 60 characters',
            'birth_date.required' => 'The birth date field is required.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password field must contain more than 6 characters.',
            'confirm_password.same' => 'Confirm password is not matched with password',
            'email.required' => 'The email field is required.',
            'status.required' => 'The status field is required.',
            'state.required' => 'The state field is required.',
            'zipcode.required' => 'The zip code field is required.',
        ];
    }
}
