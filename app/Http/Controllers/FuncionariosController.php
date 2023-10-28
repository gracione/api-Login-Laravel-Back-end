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

    public function listarFuncionarios()
    {
        $funcionarios = $this->funcionarios->getFuncionariosAndProfissao();

        if (!$funcionarios) {
            return response()->json(['message' => 'Nenhum Funcionario Encontrado'], 404);
        }

        return response()->json($funcionarios, 200);
    }

    public function dadosFuncionarioByIdUsuario(Request $request)
    {
        $idUsuario = !empty($request->id) ? $request->id : $request;

        $expediente = $this->expediente->getByIdUsuario($idUsuario);
        $funcionario = $this->funcionarios->getByIdUsuario($idUsuario);
        $profissao = $this->profissao->getByIdUsuario($idUsuario);
        $profissoes = $this->profissao->listar();

        return [
            'expediente' => $expediente, 
            'funcionario' => $funcionario, 
            'profissao' => $profissao, 
            'profissoes' => $profissoes
        ];
    }

    public function inserir(Request $request)
    {
        return $this->funcionarios->inserir($request);
    }

    public function destroyByIdUsuario(Request $request)
    {
        return $this->funcionarios->excluirByIdUsuario($request->id);
    }

    public function destroyByIdFuncionario(Request $request)
    {
        return $this->funcionarios->excluirByIdFuncionario($request->id);
    }

    public function alterar(Request $request)
    {
        return $this->funcionarios->alterar($request);
    }
}
