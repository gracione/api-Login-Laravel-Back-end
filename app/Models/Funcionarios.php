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

    public function listar()
    {
        $select = DB::table('users')
            ->join('funcionario', 'funcionario.id_usuario', '=', 'users.id')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id')
            ->select(
                DB::raw(
                    'users.nome as nome,
                    users.id as id, 
                    GROUP_CONCAT(profissao.nome) as profissão'
                )
            )
            ->groupBy('users.id')
            ->get();
        
        return $select->toArray();
    }
    public function listarFuncionariosEprofissao()
    {
        $select = DB::table('users')
            ->join('funcionario', 'funcionario.id_usuario', '=', 'users.id')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id')
            ->select(
                DB::raw(
                    'users.nome as nome,
                    users.id as id, 
                    profissao.nome as profissão'
                )
            )
            ->get();
        $funcionarios = $select->toArray();
        return $funcionarios;
    }

    public function listarById($request)
    {
        $id = !empty($request->id) ? $request->id : $request;

        $ar = DB::table('users')
            ->join('funcionario', 'funcionario.id_usuario', '=', 'users.id')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id')
            ->select(
                'users.nome as nome',
                'funcionario.id as id',
                'users.id as id_usuario',
                'users.numero as numero',
                'users.email as email',
                'users.id_sexo as id_sexo',
                'profissao.nome as  ',
                'profissao.id as id_profissao'
            )
            ->where('users.id', $id)
            ->get();
        

        return $ar->toArray();
    }

    public function inserir($request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3'
        ]);

        if ($validator->fails()) {
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
        foreach ($request->profissoesCadastradas as $key => $value) {
            DB::table('funcionario')->insert([
                'id_usuario' => $user['id'],
                'id_profissao' => $value
            ]);
        }
        DB::table('horario_trabalho')->insert([
            'inicio1' => $request->inicioExpediente . ":00",
            'fim1' => $request->inicioAlmoco . ":00",
            'inicio2' => $request->fimAlmoco . ":00",
            'fim2' => $request->fimExpediente . ":00",
            'id_usuario' => $user['id']
        ]);

        return 'cadastrado';
    }
    public function excluir($request)
    {
        DB::table('funcionario')->where('id', $request->id)->delete();
        return 'deletado';
    }
    public function alterar($request)
    {
        foreach ($request->request as $key => $value) {
            if (!empty($value)) {
                $ar[$key] = $value;
            }
        }

        if (!empty($ar['profissoesAlteradas'])) {
            foreach ($ar['profissoesAlteradas'] as $key => $value) {
                if (!empty($value)) {
                    if ($value == '-1') {

                        if (count(Funcionarios::listarById($ar['id'])) > 1) {
                            DB::table('funcionario')
                                ->where('id', $key)
                                ->delete();
                        }
                    } else if ($value != '-1') {
                        DB::table('funcionario')
                            ->where('id', $key)
                            ->update(['id_profissao' => $value]);
                    }
                }
            }
        }

        if (!empty($ar['profissoesCadastradas'])) {
            foreach ($ar['profissoesCadastradas'] as $key => $value) {
                if (!empty($value)) {
                    DB::table('funcionario')
                        ->insert(['id_usuario' => $ar['id'], 'id_profissao' => $value]);
                }
            }
        }

        DB::table('users')
            ->where('id', $request->id)
            ->update(array_filter($ar));

        return 'alterado';
    }
}
