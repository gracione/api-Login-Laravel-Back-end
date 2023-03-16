<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorarioTrabalho;

class HorarioTrabalhoController extends Controller
{
    public $expediente;

    public function __construct()
    {
        $this->expediente = new HorarioTrabalho();
    }

    public function listar()
    {
        return $this->expediente->listar();
    }
    public function listarById(Request $request)
    {
        return $this->expediente->listarByIdUsuario($request->id);
    }

    public function inserir(Request $request)
    {
        return $this->expediente->inserir($request);
    }
    public function excluir(Request $request)
    {
        return $this->expediente->excluir($request);
    }
}
