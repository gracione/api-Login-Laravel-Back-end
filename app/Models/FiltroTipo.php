<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FiltroTipo extends Model
{
    use HasFactory;
    public function listarByIdTratamento ($id) {
        $users = DB::table('filtro_tipo')
        ->join('filtro', 'filtro.id_filtro_tipo', '=', 'filtro_tipo.id')
        ->where('filtro_tipo.id_tratamento','=',$id)
        ->select('*')
        ->get();
        return $users->toArray();
    }

}
