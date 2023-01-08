<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Feriado;

class FeriadoController extends Controller
{
    public function listar()
    {
        return Feriado::listar();
    }
    public function listarById(Request $request)
    {
        return Feriado::listarById($request);
    }

    public function listarFeriadoPorMes(Request $request)
    {
        return Feriado::listarFeriadoPorMes($request);
    }
    public function inserir(Request $request)
    {
        return Feriado::inserir($request);
    }
    public function excluir(Request $request)
    {
        return Feriado::excluir($request);
    }
    public function alterar(Request $request)
    {
        try {
            Feriado::alterar($request);
        } catch (Exception $e) {
            return false;
        }

        return true;

    }
}
