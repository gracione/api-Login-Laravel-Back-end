<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ferias;

class FeriasController extends Controller
{
    public $ferias;

    public function init()
    {
        $this->ferias = new Ferias();
    }

    public function listar()
    {
        return $this->ferias->listar();
    }
    public function inserir(Request $request)
    {
        return $this->ferias->inserir($request);
    }
    public function excluir(Request $request)
    {
        return $this->ferias->excluir($request);
    }
}
