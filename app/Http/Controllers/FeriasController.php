<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ferias;

class FeriasController extends Controller
{
    public $ferias;
    
    public function init() {
        $this->ferias = new Ferias();
    }

    public function listar()
    {
        return Ferias::listar();
    }
    public function inserir(Request $request)
    {
        return Ferias::inserir($request);
    }
    public function excluir (Request $request) {
        return Ferias::excluir($request);
    }

}
