<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePassangerDetailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'passangers' => 'required|array|min:1',
            'passangers.*.name' => 'required',
            'passangers.*.date_of_birth' => 'required',
            'passangers.*.nationality' => 'required',

        ];
    }

    public function attributes()
    {
        return [
            'passangers.*.name' => 'Passanger Name',
            'passangers.*.date_of_birth' => 'Passanger Date Of Birth',
            'passangers.*.nationality' => 'Passanger Nationality',
        ];
    }

    public function messages()
    {
        return [
            'passangers.*.name.required' => ':attribute field is required.',
            'passangers.*.date_of_birth.required' => ':attribute field is required.',
            'passangers.*.nationality.required' => ':attribute field is required.',
        ];
    }
}
