<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Folgas extends Model
{
    use HasFactory;

    public function listar ($request) {
        $select = DB::table('folga')
        ->select('*')
        ->get();
        return $select;
    }
    public function inserir ($request) {    
        DB::table('folga')->insert([
            'dia_semana' => $request->dia_semana,
            'id_funcionario' => $request->id_funcionario
       ]);

       return 'cadastrado';
   }
}
