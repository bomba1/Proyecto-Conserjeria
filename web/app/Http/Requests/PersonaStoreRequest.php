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
        //TODO: validacion del digito verificador
        return [
            'rut' => 'required|cl_rut|unique:personas,rut|regex:/^\d{1,2}\.\d{3}\.\d{3}[-][0-9kK]{1}$/',
            'name' => 'required|regex:/^(?!\s*$)[-a-zA-Z]{1,50}$/',
            'phone' => 'required|numeric|between:40000000,99999999',
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
            'rut.regex' => 'El formato del rut es con puntos y guion',
            'rut.unique' => 'Este rut ya esta en uso',
            'name.required'  => 'Se necesita un nombre',
            'phone.required' =>'El teléfono debe ser completado',
            'phone.numeric' =>'El teléfono debe ser un número',
            'phone.between' =>'El teléfono indicado no existe',
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
        //TODO: pendiente validar si funciona.
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation Error',
                'error' => $validator->errors()->all()
            ], 422)
        );
    }
}
