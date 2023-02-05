<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionarios;

class FuncionariosController extends Controller
{
    public function listar()
    {
        return Funcionarios::listar();
    }
    public function listarFuncionarios(Request $request)
    {
        return Funcionarios::listarFuncionarios($request);
    }
    
    public function listarFuncionariosEprofissao()
    {
        return Funcionarios::listarFuncionariosEprofissao();
    }

    public function listarById(Request $request)
    {
        $ar = [];
        $ar['expediente'] = HorarioTrabalhoController::listarById($request);
        $ar['funcionario'] = Funcionarios::listarByIdFuncionario($request);
        $ar['profissao'] = ProfissaoController::listarByIdFuncionario($request);
        $ar['profissoes'] = ProfissaoController::listar();
        return $ar;
    }
    public function inserir(Request $request)
    {
        return Funcionarios::inserir($request);
    }
    public function excluir(Request $request)
    {
        return Funcionarios::excluir($request);
    }
    public function alterar(Request $request)
    {
        return Funcionarios::alterar($request);
    }
}
