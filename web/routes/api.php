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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Routes for Auth Controller methods(user login and register)
Route::get('/logout','Api\AuthController@logout')->middleware('auth:api');

Route::post('/register','Api\AuthController@register');
Route::post('/login','Api\AuthController@login');


Route::apiResource('/comunidad','Api\ComunidadController')->middleware('auth:api');
Route::apiResource('/persona','Api\PersonaController')->middleware('auth:api');
Route::apiResource('/propiedad','Api\PropiedadController')->middleware('auth:api');

// Cambiamos el nombre del parametro a visita, excepto pero el show.
Route::apiResource('/registro','Api\VisitaController')
    ->except(['show'])
    ->parameters(['registro' => 'visita'])->middleware('auth:api');

// Cambiamos el nombre del parametro a numero_propiedad, solo para el show.
Route::apiResource('/registro','Api\VisitaController')
    ->only(['show'])
    ->parameters(['registro' => 'numero_propiedad'])->middleware('auth:api');


