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
    public function listarFuncionariosEprofissao()
    {
        return Funcionarios::listarFuncionariosEprofissao();
    }
    
    public function listarById(Request $request)
    {
        return Funcionarios::listarById($request);
    }
    public function inserir(Request $request)
    {
        return Funcionarios::inserir($request);
    }
    public function excluir (Request $request) {
        return Funcionarios::excluir($request);
    }

}
