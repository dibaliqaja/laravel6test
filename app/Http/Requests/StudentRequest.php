<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'name'          => 'required|min:3',
            'age'           => 'required|numeric|digits_between:1,100',
            'phone_number'  => 'required|numeric|min:9|unique:students,phone_number,'.$this->student.'',
            'email'         => 'required|email|unique:students,email,'.$this->student.'',
            'major_id'      => 'required|exists:majors,id',
        ];
    }
}
