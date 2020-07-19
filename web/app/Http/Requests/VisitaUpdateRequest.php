<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VisitaUpdateRequest extends FormRequest
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
            'fecha' => 'require|date|before_or_equal:tomorrow',
            'parentesco' => 'regex:/^[aA-zZ]{2,20}$/',
            'empresa_reparto' => 'in:SI,NO',
            'persona_id' => 'exists:App\Persona,id',
            'propiedad_id' => 'exists:App\Propiedad,id',
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
            'fecha.date' => 'Fecha en formato no valido',
            'fecha.before_or_equal' => 'Fecha no valida',
            'parentesco.regex' => 'Parentesco debe ser entre 2 y 20 caracteres',
            'empresa_reparto.in' => 'Debe ser SI o NO',
            'persona_id.exists' => 'La persona no existe',
            'propiedad_id.exists' => 'La propiedad no existe',
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
