<?php
/*
 * MIT License
 *
 * Copyright (c) 2020 Leon-Salas-Santander
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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
            'telefono' => 'required|numeric|between:900000000,999999999',
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
            'telefono.between' =>'El teléfono indicado no existe(formato: 9XXXXXXXX)',
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
