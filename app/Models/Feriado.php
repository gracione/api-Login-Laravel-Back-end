<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Feriado extends Model
{
    use HasFactory;
    public function listar($request)
    {
        $select = DB::table('feriados')
            ->select('*')
            ->where('feriados.id_estabelecimento', $request->id_estabelecimento)
            ->get();
        return $select;
    }
    public function inserir($request)
    {
        DB::table('feriados')->insert([
            'nome' => $request->nome,
            'data' => $request->data,
            'id_estabelecimento' => $request->id_estabelecimento
        ]);

        return 'cadastrado';
    }
    public function excluir($request)
    {
        DB::table('feriados')->where('id', $request->id)->delete();
        return 'deletado';
    }
}
