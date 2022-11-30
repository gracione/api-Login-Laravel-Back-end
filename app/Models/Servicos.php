<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Servicos extends Model
{
    use HasFactory;
    public function listar($request)
    {
        $select = DB::table('servicos')
            ->select('*')
            ->join('users', 'users.tipo_usuario', '=', 'servicos.id_tipo_usuario')
            ->where('users.tipo_usuario',$request->idUsuario)
            ->get();
        return $select;
    }

}
