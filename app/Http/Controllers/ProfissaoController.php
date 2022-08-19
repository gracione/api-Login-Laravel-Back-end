<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profissao;

class ProfissaoController extends Controller
{
    public function inserir (Request $request) {
        return Profissao::inserir($request);
    }
    public function listar () {
        return Profissao::listar();
    }
}
