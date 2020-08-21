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
use App\Http\Requests\PersonaStoreRequest;
use App\Http\Requests\PersonaUpdateRequest;
use App\Http\Resources\PersonaResource;
use App\Persona;

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
        $personas = Persona::orderBy('id','ASC')->get();

        return response([
            'message' => 'Retrieved Successfully',
            'personas' => $personas,
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
