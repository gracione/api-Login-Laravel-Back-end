<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expediente as HorarioTrabalho;

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
    public function getById(Request $request)
    {
        return $this->expediente->getByIdUsuario($request->id);
    }

    public function inserir(Request $request)
    {
        return $this->expediente->inserir($request);
    }
    public function destroy(Request $request)
    {
        return $this->expediente->excluir($request);
    }
}
