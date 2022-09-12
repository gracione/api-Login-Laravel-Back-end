<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tratamentos;

class TratamentosController extends Controller
{
    public function listar (Request $request) {
        return Tratamentos::listar($request);
    }
    public function listarByFuncionario (Request $request) {
        return Tratamentos::listarByFuncionario($request);
    }
    public function inserir (Request $request) {
        return Tratamentos::inserir($request);
    }

}
