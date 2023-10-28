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
        return $this->ferias->all();
    }

    public function getById(Request $request)
    {
        $feriado = $this->ferias->find($request->idFeriado);

        if (!$feriado) {
            return response()->json(['message' => 'Feriado não encontrado'], 404);
        }

        return response()->json([$feriado], 200);
    }
    public function inserir(Request $request)
    {
        $this->ferias->fill(array_filter($request->all()));
        return $this->ferias->save();
    }
    public function alterar(Request $request)
    {
        $feriado = $this->ferias->find($request->id);
        return $feriado->update(array_filter($request->all()));
    }
    public function destroy(Request $request)
    {
        $feriado = $this->ferias->find($request->id);
        return $feriado->delete($request->id);
    }
}
