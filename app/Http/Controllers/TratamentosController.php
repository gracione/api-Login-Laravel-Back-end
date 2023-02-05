<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tratamentos;

class TratamentosController extends Controller
{
    public function listar () {
        return Tratamentos::listar();
    }
    public function listarById (Request $request) {
        $ar['profissoes'] = ProfissaoController::listar();
        $ar['tratamentos'] = Tratamentos::listarById($request);
        return $ar;
    }
    public function listarByIdProfissao (Request $request) {
        return Tratamentos::listarByIdProfissao($request);
    }
    public function inserir (Request $request) {
        return Tratamentos::inserir($request);
    }
    public function excluir (Request $request) {
        return Tratamentos::excluir($request);
    }

    public function alterar(Request $request)
    {
        return Tratamentos::alterar($request);
    }

}
