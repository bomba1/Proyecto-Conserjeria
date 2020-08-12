<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Validations for storage of person.
 *
 * Class PersonaStoreRequest
 * @package App\Http\Requests
 */
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
        return [
            'rut' => 'required|cl_rut|k_validator|unique:personas,rut|regex:/^\d{1,2}\.\d{3}\.\d{3}[-][0-9kK]{1}$/',
            'nombre' => 'required|regex:/^(?!\s*$)[-a-zA-Z]{1,50}$/',
            'telefono' => 'required|numeric|between:40000000,99999999',
            'email' => 'required|email:rfc,dns|unique:personas,email',
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
            'rut.required' => 'Se necesita un rut',
            'rut.cl_rut' => 'El rut no es válido',
            'rut.k_validator' => 'El rut ya existe',
            'rut.regex' => 'El formato del rut no es valido',
            'rut.unique' => 'Este rut ya esta en uso',
            'nombre.required'  => 'Se necesita un nombre',
            'telefono.required' =>'El teléfono debe ser completado',
            'telefono.numeric' =>'El teléfono debe ser un número',
            'telefono.between' =>'El teléfono indicado no existe',
            'email.required'  => 'Se necesita un correo',
            'email.email'  => 'El correo no es válido',
            'email.unique'  => 'El correo ya esta en uso',
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
            ])
        );
    }

    protected function prepareForValidation()
    {
        $this->merge([
           'rut' => strtoupper($this->rut),
        ]);
    }

}
