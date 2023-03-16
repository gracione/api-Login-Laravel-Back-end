<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\Constantes;

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
                    '
                    users.nome as nome,
                    users.id as id,
                    group_concat(profissao.nome) as profissão
                    '
                )
            )
            ->groupBy('nome', 'id');

        $result = $select->get();

        return $result->toArray();
    }

    public function listarFuncionarios($request)
    {
        $select = DB::table('users')
            ->join('funcionario', 'funcionario.id_usuario', '=', 'users.id')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id')
            ->select(
                DB::raw(
                    'users.nome as nome,
                    funcionario.id as id,
                    profissao.nome as profissão,
                    profissao.id as id_profissao'
                )
            );

        if (!empty($request->dados['tipoUsuario']) && $request->dados['tipoUsuario'] == Constantes::FUNCIONARIO) {
            $select = $select
                ->where('funcionario.id_usuario', $request->dados['idUsuario'])->get();
        } else {
            $select = $select->get();
        }

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
                    funcionario.id as id_funcionario, 
                    profissao.nome as profissão'
                )
            )
            ->get();
        $funcionarios = $select->toArray();
        return $funcionarios;
    }

    public function listarByIdUsuario($request)
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

    public function getIdUsuarioByIdFuncionario($id)
    {
        $ar = DB::table('funcionario')
            ->select('funcionario.id_usuario as id',)
            ->where('funcionario.id', $id)
            ->get();

        return $ar->toArray()[0]->id ?? null;
    }

    public function listarByIdFuncionario($request)
    {
        $id = !empty($request->id) ? $request->id : $request;

        $ar = DB::table('users')
            ->join('funcionario', 'funcionario.id_usuario', '=', 'users.id')
            ->select(
                'users.nome as nome',
                'funcionario.id as id',
                'users.id as id_usuario',
                'users.numero as numero',
                'users.email as email',
                'users.id_sexo as id_sexo'
            )
            ->where('funcionario.id_usuario', $id)
            ->get();
        $result = $ar->toArray();
        return $result[0];
    }

    public function inserir($request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3',
            'inicioExpediente' => 'required|string|min:3',
            'inicioAlmoco' => 'required|string|min:3',
            'fimAlmoco' => 'required|string|min:3',
            'fimExpediente' => 'required|string|min:3'
        ]);

        if ($validator->fails()) {
            return false;
            //return response()->json($validator->errors());
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

        return true;
    }
    public function excluir($request)
    {
        try {
            DB::table('folga')->where('id_usuario', $request->id)->delete();
            DB::table('funcionario')->where('id_usuario', $request->id)->delete();
            DB::table('horario_trabalho')->where('id_usuario', $request->id)->delete();
            DB::table('users')->where('id', $request->id)->delete();
        } catch (Exception $e) {
            return false;
        }

        return true;
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

                        if (count(Funcionarios::listarByIdUsuario($ar['id'])) > 1) {
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
            unset($ar['profissoesAlteradas']);
        }

        if (!empty($ar['profissoesCadastradas'])) {
            foreach ($ar['profissoesCadastradas'] as $key => $value) {
                if (!empty($value)) {
                    DB::table('funcionario')
                        ->insert(['id_usuario' => $ar['id'], 'id_profissao' => $value]);
                }
            }
            unset($ar['profissoesCadastradas']);
        }


        if (!empty(array_filter($ar['expediente']))) {
            DB::table('horario_trabalho')
                ->where('horario_trabalho.id_usuario', '=', $ar['id'])
                ->update(array_filter($ar['expediente']));
        }
        unset($ar['expediente']);

        if (!empty($ar['nome']) || !empty($ar['numero'])) {

            DB::table('users')
                ->where('id', '=', $ar['id'])
                ->update(array_filter($ar));
        }

        return true;
    }
}
