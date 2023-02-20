<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profissao;

class ProfissaoController extends Controller
{
    public $profissao;

    public function __construct() {
        $this->profissao = new Profissao();
    }

    public function inserir(Request $request)
    {
        return $this->profissao->inserir($request);
    }

    public function listar()
    {
        return $this->profissao->listar();
    }

    public function excluir(Request $request)
    {
        return $this->profissao->excluir($request);
    }

    public function alterar(Request $request)
    {
        return $this->profissao->alterar($request);
    }

    public function listarById(Request $request)
    {
        return $this->profissao->listarById($request);
    }
    public function listarByIdFuncionario(Request $request)
    {
        return $this->profissao->listarByIdFuncionario($request);
    }
}
