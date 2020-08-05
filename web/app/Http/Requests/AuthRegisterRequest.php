<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'email' => 'email:rfc,dns|required|unique:users',
            'password' => 'required|min:8|max:255|confirmed'
        ];
    }

    /**
     * Get the messages to send when a validation error occur.
     *
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'name.required'  => 'Se necesita un nombre',
            'name.min'  => 'Se necesita un mínimo de 3 caracteres en el nombre',
            'name.max'  => 'Se necesita un máximo de 255 caracteres en el nombre',
            'email.required'  => 'Se necesita un correo',
            'email.email'  => 'El correo no es válido',
            'email.unique'  => 'El correo ya esta en uso',
            'password.required'  => 'Se necesita una contraseña',
            'password.min'  => 'Se necesita un mínimo de 3 caracteres en la contraseña',
            'password.max'  => 'Se necesita un máximo de 255 caracteres en la contraseña',
            'password.confirmed'  => 'Se debe confirmar la contraseña',
        ];
    }


}
