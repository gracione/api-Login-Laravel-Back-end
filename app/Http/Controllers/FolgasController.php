<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folgas;

class FolgasController extends Controller
{
    public $folgas;

    public function __construct()
    {
        $this->folgas = new Folgas();
    }
    public function listar()
    {
        return $this->folgas->listar();
    }

    public function getById(Request $request)
    {
        $folgas = $this->folgas->find($request->id);

        if (!$folgas) {
            return response()->json(['message' => 'Feriado não encontrado'], 404);
        }

        return response()->json([$folgas], 200);
    }
    public function getByIdFuncionario(Request $request)
    {
        return $this->folgas->getByIdFuncionario($request);
    }
    public function inserir(Request $request)
    {
        return $this->folgas->inserir($request);
    }
    public function alterar(Request $request)
    {
        return $this->folgas->alterar($request);
    }
    public function destroy(Request $request)
    {
        $folgas = $this->folgas->find($request->id);
        return $folgas->delete($request->id);
    }
}
