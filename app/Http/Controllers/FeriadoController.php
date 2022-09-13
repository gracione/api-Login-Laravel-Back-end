<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feriado;

class FeriadoController extends Controller
{
    public function listar (Request $request) {
        return Feriado::listar($request);
    }
    public function inserir (Request $request) {
        return Feriado::inserir($request);
    }

}
