<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitaStoreRequest;
use App\Http\Requests\VisitaUpdateRequest;
use App\Http\Resources\VisitaResource;
use App\Propiedad;
use App\Visita;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // SELECT * FROM visitas
        $visitas = Visita::orderBy('fecha','ASC')->get();

        return response([
            'message' => 'Retrieved Successfully',
            'visitas' => $visitas,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitaStoreRequest $request)
    {
        // Se crea la visita
        $visita = Visita::create($request->all());

        return response([
            'message' => 'Created Successfully',
            'persona' => new VisitaResource($visita),
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        // Obtenemos las visitas a este numero de propiedad.
        $visitas = Propiedad::where('numero',$numero)->first()->visitas;

        return response([
            'message' => 'Retrieved Successfully',
            'visitas' => new VisitaResource($visitas),
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function update(VisitaUpdateRequest $request, Visita $visita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visita $visita)
    {
        //
    }
}
