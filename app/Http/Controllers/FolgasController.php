<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folgas;

class FolgasController extends Controller
{
    public function listar () {
        return Folgas::listar();
    }
    public function inserir (Request $request) {
        return Folgas::inserir($request);
    }
}
