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
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::post('/funcionarios/listar', [App\Http\Controllers\FuncionariosController::class, 'listar']);
    Route::post('/funcionarios/listarPorProfissao', [App\Http\Controllers\FuncionariosController::class, 'listarFuncionariosEprofissao']);
    Route::post('/funcionarios/listar-id', [App\Http\Controllers\FuncionariosController::class, 'dadosFuncionarioByIdUsuario']);
    Route::post('/funcionarios/listar-funcionarios', [App\Http\Controllers\FuncionariosController::class, 'listarFuncionarios']);
    Route::post('/funcionarios/inserir', [App\Http\Controllers\FuncionariosController::class, 'inserir']);
    Route::post('/funcionarios/alterar', [App\Http\Controllers\FuncionariosController::class, 'alterar']);
    Route::post('/funcionarios/excluir', [App\Http\Controllers\FuncionariosController::class, 'excluir']);

    Route::post('/tratamentos/listar-id-profissao', [App\Http\Controllers\TratamentosController::class, 'getByIdProfissao']);
    Route::post('/tratamentos/listar-id', [App\Http\Controllers\TratamentosController::class, 'getById']);
    Route::post('/tratamentos/listar', [App\Http\Controllers\TratamentosController::class, 'listar']);
    Route::post('/tratamentos/inserir', [App\Http\Controllers\TratamentosController::class, 'inserir']);
    Route::post('/tratamentos/alterar', [App\Http\Controllers\TratamentosController::class, 'alterar']);
    Route::post('/tratamentos/excluir', [App\Http\Controllers\TratamentosController::class, 'excluir']);

    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'sair']);
    Route::post('/filtro', [App\Http\Controllers\FiltroController::class, 'listar']);
    Route::post('/filtro/listar', [App\Http\Controllers\FiltroController::class, 'listarFiltro']);
    Route::post('/servicos/listar', [App\Http\Controllers\ServicosController::class, 'listar']);
    Route::post('/filtro-tipo/listar-id', [App\Http\Controllers\FiltroController::class, 'listarFiltroTipoById']);

    Route::post('/horarios-marcados/listar', [App\Http\Controllers\HorarioController::class, 'horariosMarcados']);
    Route::post('/horarios-disponivel', [App\Http\Controllers\HorarioController::class, 'horariosDiponivel']);
    Route::post('/horario/tempo-gasto', [App\Http\Controllers\HorarioController::class, 'tempoGasto']);
    Route::post('/horario/alterar', [App\Http\Controllers\HorarioController::class, 'alterar']);
    Route::post('/horario/inserir', [App\Http\Controllers\HorarioController::class, 'inserir']);
    Route::post('/horario/excluir', [App\Http\Controllers\HorarioController::class, 'desmarcar']);
    Route::post('/horario/confirmar', [App\Http\Controllers\HorarioController::class, 'confirmar']);

    Route::post('/profissao/listar', [App\Http\Controllers\ProfissaoController::class, 'listar']);
    Route::post('/profissao/listar-id', [App\Http\Controllers\ProfissaoController::class, 'getById']);
    Route::post('/profissao/listar-id-funcionario', [App\Http\Controllers\ProfissaoController::class, 'getByIdFuncionario']);
    Route::post('/profissao/inserir', [App\Http\Controllers\ProfissaoController::class, 'inserir']);
    Route::post('/profissao/alterar', [App\Http\Controllers\ProfissaoController::class, 'alterar']);
    Route::post('/profissao/excluir', [App\Http\Controllers\ProfissaoController::class, 'excluir']);

    Route::post('/feriados/listar', [App\Http\Controllers\FeriadoController::class, 'listar']);
    Route::post('/feriados/listar-id', [App\Http\Controllers\FeriadoController::class, 'getById']);
    Route::post('/feriados/listar-mes-ano', [App\Http\Controllers\FeriadoController::class, 'listarByMesAno']);
    Route::post('/feriados/inserir', [App\Http\Controllers\FeriadoController::class, 'inserir']);
    Route::post('/feriados/alterar', [App\Http\Controllers\FeriadoController::class, 'alterar']);
    Route::post('/feriados/excluir', [App\Http\Controllers\FeriadoController::class, 'excluir']);

    Route::post('/folgas/listar', [App\Http\Controllers\FolgasController::class, 'listar']);
    Route::post('/folgas/listar-id', [App\Http\Controllers\FolgasController::class, 'getById']);
    Route::post('/folgas/listar-id-funcionario', [App\Http\Controllers\FolgasController::class, 'getByIdFuncionario']);
    Route::post('/folgas/inserir', [App\Http\Controllers\FolgasController::class, 'inserir']);
    Route::post('/folgas/alterar', [App\Http\Controllers\FolgasController::class, 'alterar']);
    Route::post('/folgas/excluir', [App\Http\Controllers\FolgasController::class, 'excluir']);

    Route::post('/ferias/listar', [App\Http\Controllers\FeriasController::class, 'listar']);
    Route::post('/ferias/listar-id', [App\Http\Controllers\FeriasController::class, 'getById']);
    Route::post('/ferias/excluir', [App\Http\Controllers\FeriasController::class, 'excluir']);
    Route::post('/ferias/alterar', [App\Http\Controllers\FeriasController::class, 'alterar']);
    Route::post('/ferias/inserir', [App\Http\Controllers\FeriasController::class, 'inserir']);

    Route::post('/expediente/listar', [App\Http\Controllers\HorarioTrabalhoController::class, 'listar']);
    Route::post('/expediente/listar-id', [App\Http\Controllers\HorarioTrabalhoController::class, 'getById']);
    Route::post('/expediente/listar-id-funcionario', [App\Http\Controllers\HorarioTrabalhoController::class, 'getByIdFuncionario']);
    Route::post('/expediente/inserir', [App\Http\Controllers\HorarioTrabalhoController::class, 'inserir']);
    Route::post('/expediente/alterar', [App\Http\Controllers\HorarioTrabalhoController::class, 'alterar']);
    Route::post('/expediente/excluir', [App\Http\Controllers\HorarioTrabalhoController::class, 'excluir']);

    Route::post('/configuracao/dados-configuracao', [App\Http\Controllers\API\AuthController::class, 'dadosConfiguracao']);
    Route::post('/configuracoes/alterar', [App\Http\Controllers\API\AuthController::class, 'alterar']);
    Route::post('/configuracao-sistema/alterar', [App\Http\Controllers\ConfiguracaoController::class, 'alterar']);
    Route::post('/configuracao-sistema/listar', [App\Http\Controllers\ConfiguracaoController::class, 'listar']);
});

Route::post('/verificar-tipo-perfil', [App\Http\Controllers\Controller::class, 'verificarTipoPerfil']);
