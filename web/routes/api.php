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


Route::apiResource('/comunidad','Api\ComunidadController');
Route::apiResource('/persona','Api\PersonaController');
Route::apiResource('/propiedad','Api\PropiedadController');
Route::apiResource('/registro','Api\VisitaController');


