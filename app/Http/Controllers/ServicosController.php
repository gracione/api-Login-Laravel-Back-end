<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Servicos;

class ServicosController extends Controller
{
    public function listar(Request $request)
    {
        return Servicos::listar($request);
    }

}
