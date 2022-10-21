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

Route::post('/registrarCliente', [App\Http\Controllers\API\AuthController::class, 'registrarCliente']);
Route::post('/registrarEstabelecimento', [App\Http\Controllers\API\AuthController::class, 'registrarEstabelecimento']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::post('/funcionario/inserir', [App\Http\Controllers\FuncionariosController::class, 'inserir']); 
    Route::post('/funcionario/listar', [App\Http\Controllers\FuncionariosController::class, 'listar']);
    
    Route::post('/tratamento/listarPorFuncao', [App\Http\Controllers\TratamentosController::class, 'listar']);
    Route::post('/tratamento/listarPorFuncionario', [App\Http\Controllers\TratamentosController::class, 'listarByFuncionario']);
    Route::post('/tratamentos/listar', [App\Http\Controllers\TratamentosController::class, 'listar']);
    Route::post('/tratamentos/inserir', [App\Http\Controllers\TratamentosController::class, 'inserir']);
    Route::post('/tratamentos/excluir', [App\Http\Controllers\TratamentosController::class, 'excluir']); 
    
    Route::post('/filtro', [App\Http\Controllers\FiltroController::class, 'listar']);
    Route::post('/filtro/listar', [App\Http\Controllers\FiltroController::class, 'listarFiltro']);
    
    Route::post('/horarios-marcados', [App\Http\Controllers\HorarioController::class, 'horariosMarcados']);
    Route::post('/horarios-disponivel', [App\Http\Controllers\HorarioController::class, 'horariosDiponivel']);
    Route::post('/horario/inserir', [App\Http\Controllers\HorarioController::class, 'inserir']); 
    Route::post('/horario/desmarcar', [App\Http\Controllers\HorarioController::class, 'desmarcar']); 
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);

    Route::post('/profissao/inserir', [App\Http\Controllers\ProfissaoController::class, 'inserir']); 
    Route::post('/profissoes/excluir', [App\Http\Controllers\ProfissaoController::class, 'excluir']); 
    Route::post('/profissao/listar', [App\Http\Controllers\ProfissaoController::class, 'listar']); 
    Route::post('/profissao/alterar', [App\Http\Controllers\ProfissaoController::class, 'alterar']); 
    Route::post('/profissao/dados-alterar', [App\Http\Controllers\ProfissaoController::class, 'listarDadosAlterar']); 

    Route::post('/feriados/inserir', [App\Http\Controllers\FeriadoController::class, 'inserir']); 
    Route::post('/feriados/listar', [App\Http\Controllers\FeriadoController::class, 'listar']); 

    Route::post('/folga/inserir', [App\Http\Controllers\FolgasController::class, 'inserir']); 
    Route::post('/folga/listar', [App\Http\Controllers\FolgasController::class, 'listar']); 

    Route::post('/ferias/inserir', [App\Http\Controllers\FeriasController::class, 'inserir']); 
    Route::post('/ferias/listar', [App\Http\Controllers\FeriasController::class, 'listar']); 

    Route::post('/horarioAlmoco/inserir', [App\Http\Controllers\HorarioAlmocoController::class, 'inserir']); 
    Route::post('/horarioAlmoco/listar', [App\Http\Controllers\HorarioAlmocoController::class, 'listar']); 


});

Route::post('/verificar-tipo-perfil',[App\Http\Controllers\Controller::class,'verificarTipoPerfil']);