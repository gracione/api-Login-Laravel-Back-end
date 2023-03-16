<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Feriado;
use Illuminate\Support\Facades\App;

class FeriadoController extends Controller
{
    public $feriado;

    public function __construct()
    {
        $this->feriado = new Feriado();
    }

    public function listar()
    {
        return $this->feriado->listar();
    }
    public function listarById(Request $request)
    {
        return $this->feriado->listarById($request);
    }

    public function listarByMesAno(Request $request)
    {
        return $this->feriado->listarByMesAno($request);
    }
    public function inserir(Request $request)
    {
        return $this->feriado->inserir($request);
    }
    public function excluir(Request $request)
    {
        return $this->feriado->excluir($request);
    }
    public function alterar(Request $request)
    {
        try {
            $this->feriado->alterar($request);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
