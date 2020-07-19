<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ComunidadUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'regex:/^(?!\s*$)[-a-zA-Z]{1,50}$/',
            'direccion' => 'regex:/^(?!\s*$)[-a-zA-Z]{1,50}$/',
            'tipo' => 'in:CONDOMINIO,EDIFICIO',
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
            'nombre.regex' => 'Formato no valido, debe contener entre 5 y 50 caracteres',
            'direccion.regex' => 'Formato no valido, debe contener entre 5 y 50 caracteres',
            'tipo.in' => 'Puede ser CONDOMINIO o EDIFICIO',
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
