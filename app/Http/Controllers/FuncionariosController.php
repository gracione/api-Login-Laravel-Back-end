<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionarios;

class FuncionariosController extends Controller
{
    public function inserir (Request $request) {
        return Funcionarios::inserir($request);
    }
    public function listar (Request $request) {
        return Funcionarios::listar($request);
    }
    
}
