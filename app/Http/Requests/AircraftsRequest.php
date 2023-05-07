<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AircraftsRequest extends FormRequest
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
            'aircrafts_image' => 'required',
            'second_class' => 'required|numeric|min:10',
            'first_class' => 'required|numeric|max:10',
            'economy_class' => 'required|numeric|min:10|max:50',
            'description' => 'required',


        ];
    }
    public function messages()
    {
        return [
            'required' => 'Поле :attribute не може бути пустим  ',
            'economy_class.min' => 'Неможе бути менше 10 символів',
            'economy_class.max' => 'Неможе бути більше 50 символів',
            'first_class.min' => 'Неможе бути менше 10 символів',
            'second_class.min' => 'Неможе бути менше 10 символів',

        ];
    }
}
