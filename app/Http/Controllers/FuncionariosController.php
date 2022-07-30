<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionarios;

class FuncionariosController extends Controller
{
    public function listar () {
        return Funcionarios::funcionarios();
    }
    public function inserir (Request $request) {
        return Funcionarios::inserir($request);
    }
    
}
