<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorarioTrabalho;

class HorarioTrabalhoController extends Controller
{
    public function listar () {
        return HorarioTrabalho::listar();
       }
    public function inserir(Request $request)
    {
        return HorarioTrabalho::inserir($request);
    }
    public function excluir (Request $request) {
        return HorarioTrabalho::excluir($request);
    }

}
