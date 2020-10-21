<?php

namespace App\Http\Requests\Admin\AdminUser;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class EditProfile extends FormRequest
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
        $id = Auth::guard('admin')->id();
        $array_rule = [
            'name'    => 'required',
            'email'         => 'required|email|unique:admin_users,email,'.$id,
            'password'      => 'same:confirm_password|min:6|max:50'
        ];
        return $array_rule;
    }
}
