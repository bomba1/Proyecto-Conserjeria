<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropiedadStoreRequest;
use App\Http\Requests\PropiedadUpdateRequest;
use App\Http\Resources\PropiedadResource;
use App\Propiedad;
use Illuminate\Http\Request;

class PropiedadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // SELECT * FROM Propiedad
        $propiedades = Propiedad::orderBy('id','ASC')->get();

        return response([
            'message' => 'Retrieved Successfully',
            'propiedades' => $propiedades,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropiedadStoreRequest $request)
    {
        //Se guarda la propiedad en la base de datos
        $propiedad = Propiedad::create($request->all());

        return response([
            'message' => 'Created Successfully',
            'propiedad' => new PropiedadResource($propiedad),
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Propiedad  $propiedad
     * @return \Illuminate\Http\Response
     */
    public function show(Propiedad $propiedad)
    {
        return response([
            'message' => 'Retrieved Successfully',
            'propiedades' => new PropiedadResource($propiedad),
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Propiedad  $propiedad
     * @return \Illuminate\Http\Response
     */
    public function update(PropiedadUpdateRequest $request, Propiedad $propiedad)
    {
        // Update
        $propiedad->fill($request->all());

        $propiedad->save();

        return response([
            'message' => 'Updated Successfully',
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Propiedad  $propiedad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Propiedad $propiedad)
    {
        $propiedad->delete();
        return response([
            'message' => 'Deleted',
        ],202);
    }
}
