<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profissao extends Model
{
    use HasFactory;

    public function listar ($request) {
        $select = DB::table('profissao')
        ->select('*')
        ->get();
        return $select;
    }
    public function inserir ($request) {
         DB::table('profissao')->insert([
            'nome' => $request->nome,
            'id_estabelecimento' => $request->id_estabelecimento
        ]);

        return 'cadastrado';
    }
}
