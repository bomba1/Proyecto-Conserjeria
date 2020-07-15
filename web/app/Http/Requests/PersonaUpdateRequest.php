<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Validations for update of person.
 *
 * Class PersonaUpdateRequest
 * @package App\Http\Requests
 */
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
        $rut = $this->get('rut');

        return [
            'nombre' => 'regex:/^(?!\s*$)[-a-zA-Z]{1,50}$/',
            'email' => 'required|email:rfc,dns|unique_email_update:'.$rut,
            'telefono' =>'numeric|between:40000000,99999999',
        ];
    }

    /**
     * Get the messages to send when a validation error occur
     *
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'nombre.regex' => 'Formato de nombre inválido',
            'email.required'  => 'Se necesita un correo',
            'email.email'  => 'El correo no es válido',
            'email.unique_email_update' => 'El correo ya esta en uso',
            'telefono.numeric' =>'El teléfono debe ser un número',
            'telefono.between' =>'El teléfono indicado no existe',
        ];
    }

    /**
     * FailedValidation [Overriding the event validator for custom error response].
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation Error',
                'error' => $validator->errors()->all()
            ], 412)
        );
    }
}
