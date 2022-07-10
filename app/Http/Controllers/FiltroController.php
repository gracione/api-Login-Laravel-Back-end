<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filtro;

class FiltroController extends Controller
{
    public function listar () {
        return Filtro::listar();
    }
    public function listarFiltro (Request $request) {
        return Filtro::listarFiltro($request);
    }
}
