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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/registrar', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::get('/listarFuncionarios', [App\Http\Controllers\FuncionariosController::class, 'listar']);
    Route::post('/tratamentos', [App\Http\Controllers\TratamentosController::class, 'listar']);
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});

Route::post('/verificar-tipo-perfil',[App\Http\Controllers\Controller::class,'verificarTipoPerfil']);