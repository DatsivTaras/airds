<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightsRequest extends FormRequest
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
            'countryOfDispatch_id' => 'required',
            'citiOfDispatch_id' => 'required',
            'dateOfDispatch' => 'required',
            'countryOfArrival_id' => 'required',
            'citiOfArrival_id' => 'required',
            'dateOfArrival' => 'required',
            'aircraft_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Поле :attribute має бути вибране  ',
        ];
    }
}
