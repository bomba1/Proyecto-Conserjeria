<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonaStoreRequest;
use App\Http\Requests\PersonaUpdateRequest;
use App\Http\Resources\PersonaResource;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Muestra la lista de Personas
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonaStoreRequest $request)
    {
        // All the data in the request
        $personas = Persona::create($request->all());
        $personas->save();

        return response([
            'message' => 'Created Successfully',
            'persona' => new PersonaResource($personas),
        ],201);
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Persona  $persona
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

        if($validator->fails()) {
            return response([
                'message' => 'Rut ya en uso',
                'error' => $validator->errors(),
            ],412);
        }

        // Update

    }

    /**
     * Remove the specified resource from storage.
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
