<?php

namespace App\Http\Requests\Admin\Teachers;

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
        $maxGlobal = $this->max_global;
        $maxCafe = $this->max_cafe;
        $maxClass = $this->max_classroom;
        $maxVirtual = $this->max_virtual;

        $user_id = $this->route()->parameters()['teacher'];
        $array = [
            'firstname' => 'required',
            'lastname' => 'required',
            'dob' => 'required',
            //'email' => 'required|email|unique:users,email,'.$user_id,
            /*'status' => 'required',
            'state' => 'required',
            'zipcode' => 'required',*/
            'global_lesson_price' => 'required|max:'.$maxGlobal,
            'virtual_lesson_percentage' => 'max:'.$maxVirtual,
            'cafe_lesson_percentage' => 'max:'.$maxCafe,
            'classroom_lesson_percentage' => 'max:'.$maxClass,
            'japanese_ability' => 'required',
        ];

         if($this->japanese_ability == 'jplt_score'){
            $array['jplt_score'] = 'required';
        }
        if(!empty($this->get('password'))){
           $array = [
                'firstname' => 'required',
                'lastname' => 'required',
                'dob' => 'required',
               // 'email' => 'required|email|unique:users,email,'.$user_id,
                'status' => 'required',
                'password' => 'required|min:6',
                'confirm_password' => 'same:password',
                'state' => 'required',
                'zipcode' => 'required'
           ];
        }

        return $array ;
    }

    public function messages()
    {
        $msgs =  [
            'name.required' => 'The name field is required.',
            'birth_date.required' => 'The birth date field is required.',
            'password.required' => 'The password field is required.',
            'confirm_password.same' => 'Confirm password is not matched with password',
           // 'email.required' => 'The email field is required.',
            'status.required' => 'The status field is required.',
            'state.required' => 'The state field is required.',
            'zip_code.required' => 'The zip code field is required.',
        ];

        if($this->japanese_ability == 'jplt_score'){
            $msgs['jplt_score'] = 'The jplt score field is required.';
        }

        return $msgs;
    }
}
