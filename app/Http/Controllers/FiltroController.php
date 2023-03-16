<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filtro;
use App\Models\FiltroTipo;

class FiltroController extends Controller
{
    public $filtro;
    public $filtroTipo;

    public function __construct()
    {
        $this->filtro = new Filtro();
        $this->filtroTipo = new FiltroTipo();
    }

    public function listar()
    {
        return $this->filtro->listar();
    }

    public function listarFiltro(Request $request)
    {
        return $this->filtro->listarFiltro($request);
    }

    public function listarFiltroTipoById(Request $request)
    {
        return $this->filtroTipo->getByIdTratamento($request);
    }
}
