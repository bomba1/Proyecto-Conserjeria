<?php

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


