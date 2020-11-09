<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'name' => 'required',
            'age' => 'required',
            'sex' => 'required',
            'school' => 'required',
            'grade' => 'required',
            'class' => 'required',
            'student_no' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '姓名没有填写',
            'age.required' => '年龄没有填写',
            'sex.required' => '性别没有填写',
            'school.required' => '学校没有填写',
            'grade.required' => '年级没有填写',
            'class.required'  => '班级没有填写',
            'student_no.required'  => '学号没有填写',
        ];
    }
}
