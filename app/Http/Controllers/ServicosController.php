<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Servicos;

class ServicosController extends Controller
{
    public $servicos;

    public function __construct()
    {
        $this->servicos = new Servicos();
    }

    public function listar(Request $request)
    {
        return $this->servicos->listar($request);
    }
}
