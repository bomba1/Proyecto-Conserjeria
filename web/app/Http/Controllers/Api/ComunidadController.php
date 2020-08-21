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

use App\Comunidad;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComunidadStoreRequest;
use App\Http\Requests\ComunidadUpdateRequest;
use App\Http\Resources\ComunidadResource;

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
