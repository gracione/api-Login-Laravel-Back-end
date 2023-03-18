<?php

namespace App\Http\Controllers;

use App\Models\Profissao;
use Illuminate\Http\Request;
use App\Models\Tratamentos;

class TratamentosController extends Controller
{
    public $tratamentos;
    public $profissao;

    public function __construct()
    {
        $this->tratamentos = new Tratamentos();
        $this->profissao = new Profissao();
    }

    public function listar()
    {
        return $this->tratamentos->listar();
    }
    public function getById(Request $request)
    {
        $ar['profissoes'] = $this->profissao->listar();
        $ar['tratamentos'] = $this->tratamentos->getById($request);
        return $ar;
    }
    public function getByIdProfissao(Request $request)
    {
        return $this->tratamentos->getByIdProfissao($request);
    }
    public function inserir(Request $request)
    {
        return $this->tratamentos->inserir($request);
    }
    public function excluir(Request $request)
    {
        return $this->tratamentos->excluir($request);
    }

    public function alterar(Request $request)
    {
        return $this->tratamentos->alterar($request);
    }
}
