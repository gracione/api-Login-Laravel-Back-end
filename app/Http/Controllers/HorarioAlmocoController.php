<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorarioAlmoco;

class HorarioAlmocoController extends Controller
{
    public function listar () {
        return HorarioAlmoco::listar();
       }
    public function inserir(Request $request)
    {
        return HorarioAlmoco::inserir($request);
    }
    public function excluir (Request $request) {
        return HorarioAlmoco::excluir($request);
    }


}
