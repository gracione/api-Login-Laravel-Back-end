<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profissao;

class ProfissaoController extends Controller
{
    public function inserir (Request $request) {
        $request = Profissao::prepareInsert($request);
        return Profissao::inserir($request);
    }
    public function listar (Request $request) {
        return Profissao::listar($request);
    }
    public function excluir (Request $request) {
        return Profissao::excluir($request);
    }
}
