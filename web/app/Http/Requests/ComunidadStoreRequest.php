<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ComunidadStoreRequest extends FormRequest
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
            'nombre' => 'required|regex:/^(?!\s*$)[-a-zA-Z]{5,50}$/',
            'direccion' => 'required|regex:/^(?!\s*$)[-a-zA-Z]{5,50}$/',
            'tipo' => 'required|in:CONDOMINIO,EDIFICIO',
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
            'nombre.required' => 'Se necesita un nombre',
            'nombre.regex' => 'Formato no valido, debe contener entre 5 y 50 caracteres',
            'direccion.required' => 'Se necesita una direccion',
            'direccion.regex' => 'Formato no valido, debe contener entre 5 y 50 caracteres',
            'tipo.required' => 'Se necesita un tipo de comunidad',
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
