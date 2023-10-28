<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ferias extends Model
{
    use HasFactory;
    public function listar($request)
    {
        $select = DB::table('ferias')
            ->select('*')
            ->get();
        return $select;
    }
    public function inserir($request)
    {
        DB::table('ferias')->insert([
            'inicio' => $request->inicio,
            'fim' => $request->fim,
            'id_funcionario' => $request->id_funcionario
        ]);

        return true;
    }
}
