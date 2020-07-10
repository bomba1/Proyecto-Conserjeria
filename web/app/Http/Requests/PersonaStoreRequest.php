<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaStoreRequest extends FormRequest
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
        //TODO: validacion del digito verificador
        return [
            'rut' => 'required|unique:personas,rut|regex:/^\d{1,2}\.\d{3}\.\d{3}[-][0-9kK]{1}$/',
            'name' => 'required',
            'phone' => 'numeric|between:40000000,99999999',
            'email' => 'required|email:rfc,dns|unique:personas,email',
        ];
    }

    public function messages()
    {
        return [
            'rut.required' => 'Se necesita un rut',
            'rut.regex' => 'El formato del rut es con puntos y guion',
            'rut.unique' => 'Este rut ya esta en uso',
            'name.required'  => 'Se necesita un nombre',
            'phone.numeric' =>'El teléfono debe ser un número',
            'phone.between' =>'El teléfono indicado no existe',
            'email.required'  => 'Se necesita un correo',
            'email.email'  => 'El correo no es válido',
            'email.unique'  => 'El correo ya esta en uso',
        ];
    }
}
