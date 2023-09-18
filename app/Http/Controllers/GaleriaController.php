<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Galeria;
use Illuminate\Support\Facades\App;

class GaleriaController extends Controller
{
    public $galeria;

    public function __construct()
    {
        $this->galeria = new Galeria();
    }

    public function listar()
    {
        return $this->galeria->listar();
    }

    public function fotosAlbum(Request $request)
    {
        return $this->galeria->fotosAlbum($request);
    }

    public function inserir(Request $request)
    {
        return $this->galeria->inserir($request);
    }

    public function excluir(Request $request)
    {
        return $this->galeria->excluir($request->id);
    }
    public function alterar(Request $request)
    {
        try {
            $this->galeria->alterar($request);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
