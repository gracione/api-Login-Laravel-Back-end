<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionarios;

class FuncionariosController extends Controller
{
    public function listar(Request $request)
    {
        return Funcionarios::listar($request);
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
        return Funcionarios::listarByIdFuncionario($request);
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
