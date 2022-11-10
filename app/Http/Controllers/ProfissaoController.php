<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profissao;

class ProfissaoController extends Controller
{
    public function inserir(Request $request)
    {
        return Profissao::inserir($request);
    }

    public function listar()
    {
        return Profissao::listar();
    }

    public function excluir(Request $request)
    {
        return Profissao::excluir($request);
    }

    public function alterar(Request $request)
    {
        return Profissao::alterar($request);
    }

    public function listarById(Request $request)
    {
        return Profissao::listarById($request);
    }
    public function listarByIdFuncionario(Request $request)
    {
        return Profissao::listarByIdFuncionario($request);
    }
}
