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

    public function funcionarios () {
        $users = DB::table('users')
        ->join('funcao_funcionario', 'funcao_funcionario.id_usuario', '=', 'users.id')
        ->join('funcao_tipo', 'funcao_tipo.id', '=', 'funcao_funcionario.id_funcao_tipo')
        ->select('users.nome as nome_usuario','users.id as id_usuario', 'funcao_tipo.nome as funcao', 'funcao_tipo.id as id_funcao')
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
            'nome_estabelecimento' => '',
            'nome' => $request->nome,
            'numero' => $request->numero,
            'usuario_tipo' => '2',
            'id_sexo' => $request->id_sexo,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);

         
//         DB::table('funcionario')->insert([
//            'id' => '1',
//            'id_estabelecimento' => '1',
//            'id_funcionario' => $user['id']
//        ]);
        print("<pre>");
        print_r($user['id']);
         return 'cadastrado';
    }
}
