<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;
use Validator;
use DB;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $id         = $this->route()->parameters()['category'];
        $parent_id  = $this->get('parent_id',0);

        Validator::extend('uniqueValidation', function ($attribute, $value, $parameters, $validator) use ($parent_id,$id) {
            $count = DB::table('categories')
                ->where('name','ilike', strtolower($value))
                ->where('parent_id', $parent_id)
                ->where('id','!=' ,$id)
                ->count();
            return $count === 0;
        });

        Validator::replacer('uniqueValidation', function ($message, $attribute, $rule, $parameters) {
            return 'Category already exist with this Parent.';
        });

        $array_rule = [
            'name' => 'required|max:255|uniqueValidation',
            'status' => 'required'
        ];
        return $array_rule;
    }

    public function messages()
    {
        return [
            'status.required'  => 'Please Select Status',
            'name.max' => 'Name may not be greater than 255 characters.',
        ];
    }



}
