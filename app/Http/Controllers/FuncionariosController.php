<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionarios;
use App\Models\HorarioTrabalho;
use App\Models\Profissao;

class FuncionariosController extends Controller
{
    private $funcionarios;
    private $expediente;
    private $profissao;

    public function __construct(Funcionarios $funcionarios, HorarioTrabalho $expediente, Profissao $profissao)
    {
        $this->funcionarios = $funcionarios;
        $this->expediente = $expediente;
        $this->profissao = $profissao;
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
        $valor = [
            'expediente' => $this->expediente->getById($request),
            'funcionario' => $this->funcionarios->getByIdFuncionario($request),
            'profissao' => $this->profissao->getByIdFuncionario($request),
            'profissoes' => $this->profissao->listar()
        ];
        return $valor;
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
