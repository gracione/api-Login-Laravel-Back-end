<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folgas;

class FolgasController extends Controller
{
    public function listar () {
        return Folgas::listar();
    }
    public function listarById (Request $request) {
        return Folgas::listarById($request);
    }
    public function listarByIdFuncionario (Request $request) {
        return Folgas::listarByIdFuncionario($request);
    }
    public function inserir (Request $request) {
        return Folgas::inserir($request);
    }
    public function excluir (Request $request) {
        return Folgas::excluir($request);
    }
    public function alterar (Request $request) {
        return Folgas::alterar($request);
    }


}
