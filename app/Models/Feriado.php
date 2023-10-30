<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Feriado extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['data', 'nome'];

    public function listarByMesAno(int $mes, int $ano)
    {
        if ($mes < 1 || $mes > 12 || $ano < 1900) {
            return ['error' => 'Parâmetros de mês ou ano inválidos'];
        }

        $feriados = Feriado::selectRaw('DAY(data) as dia, nome')
            ->whereMonth('data', $mes)
            ->whereYear('data', $ano)
            ->get();

        $feriadosAssociativos = $feriados->pluck('nome', 'dia')->toArray();

        return $feriadosAssociativos;
    }

    public function verificarFeriado($request)
    {
        $data = explode('-', $request->data);
        $select = DB::table('feriados')
            ->select(DB::raw('DAY(data) as dia, nome', 'feriados as feriados.id'))
            ->whereMonth('feriados.data', $data[1])
            ->whereYear('feriados.data', $data[0])
            ->whereDay('feriados.data', $data[2])
            ->get();

        $results = $select->toArray();
        return !empty($results[0]) ? true : false;
    }
}
