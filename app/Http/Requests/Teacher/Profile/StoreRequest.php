<?php
namespace App\Http\Requests\Teacher\Profile;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'teaching_year_begun' => 'required',
            'japanese_ability' => 'required',
            'hobby' => 'required',
            'message_en' => 'required',
            'courses_teach' => 'required',
//            'global_lesson_price' => 'required'
        ];

        if($this->japanese_ability == 'jplt_score'){
            $rules['jplt_score'] = 'required';
        }

        return $rules;
           
    }

    public function messages() {
        $msgs = [
            'teaching_year_begun.required' => 'The year started teaching certification field is required.',
            'japanese_ability.required' => 'The japanese ability certification field is required.',
            'hobby.required' => 'The hobby field is required.',
            'message_en.required' => 'The message to student field is required.',
            'courses_teach.required' => 'The courses field is required.',
//            'global_lesson_price.required' => 'The global lesson price field is required.',
      
        ];

        if($this->japanese_ability == 'jplt_score'){
            $msgs['jplt_score'] = 'The jplt score field is required.';
        }

        return $msgs;
    }
}
