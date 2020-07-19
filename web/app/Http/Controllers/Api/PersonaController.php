<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonaStoreRequest;
use App\Http\Requests\PersonaUpdateRequest;
use App\Http\Resources\PersonaResource;
use App\Persona;
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
        $persona = Persona::orderBy('id','ASC')->get();

        return response([
            'message' => 'Retrieved Successfully',
            'personas' => $persona,
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
        $data = $request->all();

        //Se guarda la persona en la base de datos
        $persona = Persona::create($data);

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
        // Update
        $persona->fill($request->all());

        $persona->save();

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
