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

class VisitaStoreRequest extends FormRequest
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
            'fecha' => 'required|date|before_or_equal:tomorrow',
            'parentesco' => 'required|regex:/^[aA-zZ]{2,20}$/',
            'empresa_reparto' => 'required|in:SI,NO',
            'persona_rut' => 'required|exists:App\Persona,rut',
            'propiedad_numero' => 'required|exists:App\Propiedad,numero',
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
            'fecha.required' => 'Se necesita una fecha',
            'fecha.date' => 'Fecha en formato no valido',
            'fecha.before_or_equal' => 'Fecha no valida',
            'parentesco.required' => 'Se requiere parentesco',
            'parentesco.regex' => 'Parentesco debe ser entre 2 y 20 caracteres',
            'empresa_reparto.required' => 'Se requiere saber si es una empresa de reparto',
            'empresa_reparto.in' => 'Debe ser SI o NO',
            'persona_rut.required' => 'Se requiere el rut de la persona',
            'persona_rut.exists' => 'La persona no existe o el rut esta en el formato incorrecto',
            'propiedad_numero.required' => 'Se requiere el numero de propiedad',
            'propiedad_numero.exists' => 'La propiedad no existe',
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
            'persona_rut' => strtoupper($this->persona_rut),
        ]);
    }
}
