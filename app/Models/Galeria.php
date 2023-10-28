<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Galeria extends Model
{
    use HasFactory;
    public function listar()
    {
        $select = DB::table('albuns')
            ->select(
                'albuns.id as id',
                'albuns.nome as nome'
            )
            ->get();
        return $select->toArray();
    }

    public function fotosAlbum($request) {
        $select = DB::table('imagens')
            ->select(
                'imagens.nome_arquivo as imageUrl'
            )
            ->where('album_id', '=', $request->id)
            ->get();
        $test = $select->toArray();
        return $test;
    }

    public function getById($request)
    {
        $select = DB::table('albuns')
            ->select('*')
            ->where('id', '=', $request->idFeriado)
            ->get();
        return $select;
    }

    public function inserir($request)
    {
        DB::table('albuns')->insert([
            'nome' => $request->nome,
            'descricao' => ''
        ]);

        return true;
    }
    public function alterar($request)
    {
        foreach ($request->request as $key => $value) {
            if ($value) {
                $ar[$key] = $value;
            }
        }
        DB::table('feriados')
            ->where('id', $request->id)
            ->update(array_filter($ar));

        return true;
    }
}
