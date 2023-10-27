<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Feriado extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['data','nome'];

    public function listarByMesAno($request)
    {
        $select = DB::table('feriados')
            ->select(DB::raw('DAY(data) as dia, nome'))
            ->whereMonth('feriados.data', $request['mes'])
            ->whereYear('feriados.data', $request['ano'])
            ->get();
        $results = $select->toArray();

        $arr = [];
        foreach ($results as $value) {
            $arr[$value->dia] = $value->nome;
        }
        return $arr;
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
