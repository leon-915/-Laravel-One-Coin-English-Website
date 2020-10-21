<?php

namespace App\Http\Requests\Admin\Location;

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
            'title' => 'required|max:255',
            'title_jp' => 'required|max:255',
            //'seats_available' => 'required',
            //'phone_no' => 'required|',
            //'address' => 'required|max:255',
            //'country' => 'required',
            //'state' => 'required',
            //'city' => 'required',
            'zipcode' => 'max:7',
            'location_type' => 'required',
            'status' => 'required',
        ];
        return $array_rule;
    }

    public function messages()
    {
        return [
            'title.required' => 'Please Enter Title',
            'title_jp.required' => 'Please Enter Title in Japanese',
            'seats_available.required' => 'Please Select Seats',
            //'phone_no.required' => 'Please Enter Phone Number',
            //'address.required' => 'Please Enter Address',
            //'country.required' => 'Please Select Country',
            //'state.required' => 'Please Select State',
            //'city.required' => 'Please select City',
            //'zipcode.required' => 'Please Enter Zipcode',
            'location_type.required' => 'Please Select Location Type',
            'status.required'  => 'Please Select Status',
        ];
    }
}
