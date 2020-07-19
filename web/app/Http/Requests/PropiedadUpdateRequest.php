<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PropiedadUpdateRequest extends FormRequest
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
        $id = $this->get('id');

        return [
            'numero' => 'integer|unique_numero_update:'.$id,
            'tipo' => 'in:CASA,DEPARTAMENTO',
            'comunidad_id' => 'exists:App\Comunidad,id',
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
            'numero.unique_numero_update' => 'El numero ya esta en uso',
            'numero.integer' => 'Ingrese un numero entero porfavor',
            'tipo.in' => 'Porfavor solo ingrese si es una CASA o DEPARTAMENTO',
            'comunidad_id.exists' => 'El condominio al cual se intento agregar la propiedad no existe',
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
