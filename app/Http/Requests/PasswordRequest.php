<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'current_password' =>'required|current_password',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',

        ];
    }
    public function messages()
    {
        return [
            'current_password.current_password' => 'Неправильний пароль',
            'password.confirmed' => 'Неспівпадає пароль',

        ];
    }
}
