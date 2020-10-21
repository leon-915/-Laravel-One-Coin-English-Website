<?php

namespace App\Http\Requests\Admin\Coupons;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $array_rule = [
            'coupon_code' => 'required|max:255',
            'discount' => 'required|numeric',
            'from_date' => 'required',
            'to_date' => 'required',
            'status' => 'required',
        ];
        return $array_rule;
    }
    public function messages()
    {
        return [
            'coupon_code.required'=>'Please Enter Coupon Code',
            'discount.required'=>'Please Enter Discount',
            'from_date.required'=>'Please Select From Date',
            'to_date.required'=>'Please Select To Date',
            'status.required'=>'Please Select Status',
        ];
    }
}
