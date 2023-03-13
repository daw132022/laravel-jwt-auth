<?php

use App\Http\Controllers\AuthController;
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





/*Route::post('peticiones',
    [\App\Http\Controllers\PeticionesController::class, 'store']);*/
Route::post('peticiones',
    [\App\Http\Controllers\PeticionesController::class, 'store2']);
Route::get('/peticiones/listado',
    [\App\Http\Controllers\PeticionesController::class, 'list']);
Route::get('/peticiones/firmar/{id}',
    [\App\Http\Controllers\PeticionesController::class, 'firmar']);
Route::put('/peticiones/estado/{id}',
    [\App\Http\Controllers\PeticionesController::class, 'cambiarEstado']);
Route::put('/peticiones/{peticione}',
    [\App\Http\Controllers\PeticionesController::class, 'update']);
Route::get('/mispeticiones/',
    [\App\Http\Controllers\PeticionesController::class, 'listMine']);
Route::get('/users/firmas',
    [\App\Http\Controllers\UsersController::class, 'peticionesFirmadas']);
Route::get('peticiones/{peticiones}',
    [\App\Http\Controllers\PeticionesController::class, 'show']);
Route::get('peticiones',
    [\App\Http\Controllers\PeticionesController::class, 'index']);
Route::delete('peticiones/{peticiones}',
    [\App\Http\Controllers\PeticionesController::class, 'destroy']);



Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/login', 'login');
    Route::post('/auth/register', 'register');
    Route::post('/auth/logout', 'logout');
    Route::post('/auth/refresh', 'refresh');
    Route::get('/auth/me', 'me');
});

