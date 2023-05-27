<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Http\Controllers\API\Constantes;

class Funcionarios extends Model
{
    use HasFactory;

    protected $table = 'funcionario';

    protected $fillable = [
        'id_usuario',
        'id_profissao',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function profissao()
    {
        return $this->belongsTo(Profissao::class, 'id_profissao');
    }

    public function listar()
    {
        return $this->select(
            'users.nome as nome',
            'users.id as id',
            DB::raw('group_concat(profissao.nome) as profissao')
        )
            ->join('users', 'funcionario.id_usuario', '=', 'users.id')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id')
            ->groupBy('nome', 'id')
            ->get()
            ->toArray();
    }

    public function listarFuncionarios($request)
    {
        $select = $this->select(
            'users.nome as nome',
            'funcionario.id as id',
            'profissao.nome as profissao',
            'profissao.id as id_profissao'
        )
            ->join('users', 'funcionario.id_usuario', '=', 'users.id')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id');

        if (!empty($request->dados['tipoUsuario']) && $request->dados['tipoUsuario'] == Constantes::FUNCIONARIO) {
            $select = $select->where('funcionario.id_usuario', $request->dados['idUsuario']);
        }

        return $select->get()->toArray();
    }

    public function listarFuncionariosEprofissao()
    {
        return $this->select(
            'users.nome as nome',
            'users.id as id',
            'funcionario.id as id_funcionario',
            'profissao.nome as profissao'
        )
            ->join('users', 'funcionario.id_usuario', '=', 'users.id')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id')
            ->get()
            ->toArray();
    }

    public function getByIdUsuario($request)
    {
        $id = !empty($request->id) ? $request->id : $request;

        return $this->select(
            'users.nome as nome',
            'funcionario.id as id',
            'users.id as id_usuario',
            'users.numero as numero',
            'users.email as email',
            'users.id_sexo as id_sexo',
            'profissao.nome as profissao',
            'profissao.id as id_profissao'
        )
            ->join('users', 'funcionario.id_usuario', '=', 'users.id')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id')
            ->where('users.id', $id)
            ->get()
            ->toArray();
    }

    public static function getIdUsuarioByIdFuncionario($id)
    {
        return self::select('id_usuario as id')
            ->where('id', $id)
            ->pluck('id')
            ->first();
    }

    public function getByIdFuncionario($request)
    {
        $id = !empty($request->id) ? $request->id : $request;

        return $this->select(
            'users.nome as nome',
            'funcionario.id as id',
            'users.id as id_usuario',
            'users.numero as numero',
            'users.email as email',
            'users.id_sexo as id_sexo'
        )
            ->join('users', 'funcionario.id_usuario', '=', 'users.id')
            ->where('funcionario.id_usuario', $id)
            ->first()->toArray();
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
        }

        $user = User::create([
            'nome' => $request->nome,
            'numero' => $request->numero,
            'tipo_usuario' => '2',
            'id_sexo' => $request->id_sexo,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $this->id_usuario = $user->id;
        $this->id_profissao = $request->profissoesCadastradas;
        $this->save();

        HorarioTrabalho::create([
            'inicio1' => $request->inicioExpediente . ":00",
            'fim1' => $request->inicioAlmoco . ":00",
            'inicio2' => $request->fimAlmoco . ":00",
            'fim2' => $request->fimExpediente . ":00",
            'id_usuario' => $user->id
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
        $ar = array_filter($request->request);

        if (!empty($ar['profissoesAlteradas'])) {
            foreach ($ar['profissoesAlteradas'] as $key => $value) {
                if ($value == '-1') {
                    if (count(Funcionarios::getByIdUsuario($ar['id'])) > 1) {
                        DB::table('funcionario')->where('id', $key)->delete();
                    }
                } else if ($value != '-1') {
                    DB::table('funcionario')->where('id', $key)->update(['id_profissao' => $value]);
                }
            }
            unset($ar['profissoesAlteradas']);
        }

        if (!empty($ar['profissoesCadastradas'])) {
            foreach ($ar['profissoesCadastradas'] as $key => $value) {
                if (!empty($value)) {
                    DB::table('funcionario')->insert(['id_usuario' => $ar['id'], 'id_profissao' => $value]);
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
