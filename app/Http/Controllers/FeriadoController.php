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
        return $this->feriado->all();
    }

    public function getById(Request $request)
    {
        $feriado = $this->feriado->find($request->idFeriado);

        if (!$feriado) {
            return response()->json(['message' => 'Feriado não encontrado'], 404);
        }

        return response()->json([$feriado], 200);
    }
    public function inserir(Request $request)
    {
        $this->feriado->fill(array_filter($request->all()));
        return $this->feriado->save();
    }
    public function alterar(Request $request)
    {
        $feriado = $this->feriado->find($request->id);
        return $feriado->update(array_filter($request->all()));
    }
    public function destroy(Request $request)
    {
        $feriado = $this->feriado->find($request->id);
        return $feriado->delete($request->id);
    }

    public function listarByMesAno(Request $request)
    {
        return $this->feriado->listarByMesAno((int) $request['mes'],(int) $request['ano']);
    }
}
