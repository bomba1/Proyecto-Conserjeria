<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonaStoreRequest;
use App\Http\Requests\PersonaUpdateRequest;
use App\Http\Resources\PersonaResource;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class PersonaController
 * @package App\Http\Controllers\Api
 */
class PersonaController extends Controller
{
    /**
     * Display a listing of persons.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // SELECT * FROM personas
        $personas = Persona::orderBy('id','DESC');
        return response([
            'message' => 'Retrieved Successfully',
            'personas' => PersonaResource::collection($personas),
        ]);
    }

    /**
     * Storing a validated person in the database.
     *
     * @param PersonaStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonaStoreRequest $request)
    {
        //TODO: hacer validacion para rut unico considerando k mayuscula o minuscula(sqlite es case sensitive)

        //TODO: ingresar el rut con k mayuscula si aplica
        // All the data in the request
        $persona = Persona::create($request->all());
        $persona->save();

        return response([
            'message' => 'Created Successfully',
            'persona' => new PersonaResource($persona),
        ],201);
    }

    /**
     * Display the specified person.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        return response([
            'message' => 'Retrieved Successfully',
            'persona' => new PersonaResource($persona),
        ],200);
    }

    /**
     * Update a validated person in the database.
     *
     * @param PersonaUpdateRequest $request
     * @param Persona $persona
     * @return \Illuminate\Http\Response
     */
    public function update(PersonaUpdateRequest $request, Persona $persona)
    {
        // Validacion adicional para que el unique del correo no afecte a si mismo.
        // Pendiente validar si funciona.
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                Rule::unique('personas')->ignore($persona),
            ]
        ]);

        if ($validator->fails()) {
            return response([
                'message' => 'Rut ya en uso',
                'error' => $validator->errors(),
            ], 412);
        }

        // Update
        $persona->update($request->all());

        return response([
            'message' => 'Updated Successfully',
        ], 202);
    }

    /**
     * Remove the specified person from storage.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        $persona->delete();
        return response([
            'message' => 'Deleted',
        ],202);
    }
}
