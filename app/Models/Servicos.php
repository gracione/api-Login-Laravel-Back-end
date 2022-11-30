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
            ->where('id_tipo_usuario',$request->id)
            ->get();
        return $select;
    }

}
