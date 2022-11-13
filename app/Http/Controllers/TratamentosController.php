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
        return Tratamentos::listarById($request);
    }
    public function inserir (Request $request) {
        return Tratamentos::inserir($request);
    }
    public function excluir (Request $request) {
        return Tratamentos::excluir($request);
    }

}
