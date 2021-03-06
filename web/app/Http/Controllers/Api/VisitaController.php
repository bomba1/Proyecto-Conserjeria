<?php
/*
 * MIT License
 *
 * Copyright (c) 2020 Leon-Salas-Santander
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitaStoreRequest;
use App\Http\Requests\VisitaUpdateRequest;
use App\Http\Resources\VisitaResource;
use App\Persona;
use App\Propiedad;
use App\Visita;
use Illuminate\Http\Request;

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
        $id_persona = Persona::where('rut', $request->persona_rut)->first()->id;
        $id_propiedad = Propiedad::where('numero', $request->propiedad_numero)->first()->id;

        $newRequest = new Request([
            'fecha'   => $request->fecha,
            'parentesco'  => $request->parentesco,
            'empresa_reparto'  => $request->empresa_reparto,
            'persona_id'  => $id_persona,
            'propiedad_id'  => $id_propiedad,
        ]);

        // Se crea la visita
        $visita = Visita::create($newRequest->all());

        return response([
            'message' => 'Created Successfully',
            'visita' => new VisitaResource($visita),
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function show($numero_propiedad)
    {
        // Obtenemos las visitas a este numero de propiedad.
        $visitas = Propiedad::where('numero',$numero_propiedad)->first()->visitas;

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
        // Update
        $visita->fill($request->all());

        $visita->save();

        return response([
            'message' => 'Updated Successfully',
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visita $visita)
    {
        $visita->delete();
        return response([
            'message' => 'Deleted',
        ],202);
    }
}
