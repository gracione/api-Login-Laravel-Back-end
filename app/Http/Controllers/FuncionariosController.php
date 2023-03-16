<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionarios;
use App\Models\HorarioTrabalho;
use App\Models\Profissao;

class FuncionariosController extends Controller
{
    public $funcionarios;
    public $expediente;
    public $profissao;

    public function __construct()
    {
        $this->funcionarios = new Funcionarios();
        $this->expediente = new HorarioTrabalho();
        $this->profissao = new Profissao();
    }

    public function listar()
    {
        return $this->funcionarios->listar();
    }
    public function listarFuncionarios(Request $request)
    {
        return $this->funcionarios->listarFuncionarios($request);
    }

    public function listarFuncionariosEprofissao()
    {
        return $this->funcionarios->listarFuncionariosEprofissao();
    }

    public function getById(Request $request)
    {
        $ar = [];
        $ar['expediente'] = $this->expediente->getById($request);
        $ar['funcionario'] = $this->funcionarios->getByIdFuncionario($request);
        $ar['profissao'] = $this->profissao->getByIdFuncionario($request);
        $ar['profissoes'] = $this->profissao->listar();
        return $ar;
    }
    public function inserir(Request $request)
    {
        return $this->funcionarios->inserir($request);
    }
    public function excluir(Request $request)
    {
        return $this->funcionarios->excluir($request);
    }
    public function alterar(Request $request)
    {
        return $this->funcionarios->alterar($request);
    }
}
