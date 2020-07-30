<?php

namespace App\Http\Controllers\Api;

use App\Comunidad;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComunidadStoreRequest;
use App\Http\Requests\ComunidadUpdateRequest;
use App\Http\Resources\ComunidadResource;
use Illuminate\Http\Request;

class ComunidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // SELECT * FROM personas
        $comunidades = Comunidad::orderBy('id','ASC')->get();

        return response([
            'message' => 'Retrieved Successfully',
            'comunidades' => $comunidades,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComunidadStoreRequest $request)
    {
        //Se guarda la persona en la base de datos
        $comunidad = Comunidad::create($request->all());

        return response([
            'message' => 'Created Successfully',
            'comunidad' => new ComunidadResource($comunidad),
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comunidad  $comunidad
     * @return \Illuminate\Http\Response
     */
    public function show(Comunidad $comunidad)
    {
        return response([
            'message' => 'Retrieved Successfully',
            'comunidad' => new ComunidadResource($comunidad),
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comunidad  $comunidad
     * @return \Illuminate\Http\Response
     */
    public function update(ComunidadUpdateRequest $request, Comunidad $comunidad)
    {
        // Update
        $comunidad->fill($request->all());

        $comunidad->save();

        return response([
            'message' => 'Updated Successfully',
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comunidad  $comunidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comunidad $comunidad)
    {
        $comunidad->delete();
        return response([
            'message' => 'Deleted',
        ],202);
    }
}
