<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaUpdateRequest extends FormRequest
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
            'name' => 'required|regex:/^(?!\s*$)[-a-zA-Z]{1,50}$/',
            'email' => 'required|email|unique:personas,email',
            'phone' =>'numeric|between:40000000,99999999',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.regex' => 'Formato de nombre inválido',
            'email.required'  => 'Se necesita un correo',
            'email.email'  => 'El correo no es válido',
            'email.unique'  => 'El correo ya se encuentra en uso.',
            'phone.numeric' =>'El teléfono debe ser un número',
            'phone.between' =>'El teléfono indicado no existe',
        ];
    }
}
