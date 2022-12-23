<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreateTask extends FormRequest
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
    public function rules(Request $request)
    {
        $validate = [
            'title'         => 'required',
            'period'        => 'required'
        ];

        if($request->period == 9) {
            $validate['start_date'] = 'required';
        }
        else {
            $validate['start_date'] = 'required|before:end_date';   
            $validate['end_date']   = 'required|after:start_date';   
        }

        return $validate;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'         => 'Please enter title.',
            'period.required'        => 'Please select period.',
            'start_date.required'    => 'Please select start date.',
            'end_date.required'      => 'Please select end date.',
        ];
    }
}
