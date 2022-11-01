<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feriado;

class FeriadoController extends Controller
{
    public function listar (Request $request) {
        return Feriado::listar($request);
    }
    public function listarById (Request $request) {
        return Feriado::listarById($request);
    }
    
    public function listarFeriadoPorMes (Request $request) {
        return Feriado::listarFeriadoPorMes($request);
    }
    public function inserir (Request $request) {
        return Feriado::inserir($request);
    }
    public function excluir (Request $request) {
        return Feriado::excluir($request);
    }

}
