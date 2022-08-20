<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Hash;

class Funcionarios extends Model
{
    use HasFactory;

    public function listar ($request) {
        $users = DB::table('users')
        ->join('funcionario', 'funcionario.id_usuario', '=', 'users.id')
        ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id')
        ->select('users.nome as nome_usuario','users.id as id_usuario', 'profissao.nome as funcao', 'profissao.id as id_funcao')
        ->where('funcionario.id_estabelecimento',$request->id_estabelecimento)
        ->get();
        return $users;
    }

    public function inserir ($request) {
        $validator = Validator::make($request->all(),[
            'nome' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'nome' => $request->nome,
            'numero' => $request->numero,
            'tipo_usuario' => '2',
            'id_sexo' => $request->id_sexo,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);
         print($user['id']);
         
         DB::table('funcionario')->insert([
            'id_estabelecimento' => $request->id_estabelecimento,
            'id_usuario' => $user['id'],
            'id_profissao' => $request->id_funcao_tipo
        ]);

        return 'cadastrado';
    }
}
