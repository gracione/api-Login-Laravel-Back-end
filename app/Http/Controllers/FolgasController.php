<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folgas;

class FolgasController extends Controller
{
    public $folgas;

    public function __construct()
    {
        $this->folgas = new Folgas();
    }
    public function listar()
    {
        return $this->folgas->listar();
    }
    public function getById(Request $request)
    {
        return $this->folgas->getById($request);
    }
    public function getByIdFuncionario(Request $request)
    {
        return $this->folgas->getByIdFuncionario($request);
    }
    public function inserir(Request $request)
    {
        return $this->folgas->inserir($request);
    }
    public function destroy(Request $request)
    {
        return $this->folgas->excluir($request);
    }
    public function alterar(Request $request)
    {
        return $this->folgas->alterar($request);
    }
}
