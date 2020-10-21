<?php

namespace App\Http\Requests\Admin\AdminUser;

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
        $array_rule = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:admin_users,email',
            'password' => 'required|same:confirm_password|min:6|max:50',
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
