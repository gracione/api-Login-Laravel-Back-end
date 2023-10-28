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

    public function getFuncionariosAndProfissao()
    {
        $select = $this->select(
            'users.nome as nome',
            'funcionario.id as id',
            'profissao.nome as profissao',
            'funcionario.id as id_funcionario',
            'profissao.id as id_profissao'
        )
            ->join('users', 'funcionario.id_usuario', '=', 'users.id')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id');

        $tipoUsuario = auth()->user()->tipo_usuario;
        $idUsuario = auth()->user()->id;
            
        if ($tipoUsuario == Constantes::FUNCIONARIO) {
            $select = $select->where('funcionario.id_usuario', $idUsuario);
        }

        return $select->get()->toArray();
    }

    public function getByIdUsuario($id)
    {
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
            ->get()->first()
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
            'email' => 'required|string|email|max:255|unique:users',
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
            'password' => Hash::make($request->password),
            'img_url' => './perfil/sem_usuario.png'
        ]);

        foreach ($request->profissoesCadastradas as $key => $idProfissao) {
            self::create([
                'id_usuario' => $user->id,
                'id_profissao' => $idProfissao
            ]);
        }

        HorarioTrabalho::create([
            'inicio1' => $request->inicioExpediente . ":00",
            'fim1' => $request->inicioAlmoco . ":00",
            'inicio2' => $request->fimAlmoco . ":00",
            'fim2' => $request->fimExpediente . ":00",
            'id_usuario' => $user->id
        ]);

        return true;
    }

    public function destroyByIdUsuario($idUsuario)
    {
        try {
            DB::table('folga')->where('id_usuario', $idUsuario)->delete();
            DB::table('funcionario')->where('id_usuario', $idUsuario)->delete();
            DB::table('horario_trabalho')->where('id_usuario', $idUsuario)->delete();
            DB::table('users')->where('id', $idUsuario)->delete();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function destroyByIdFuncionario($idFuncionario)
    {

        try {
            $idUsuario = self::getIdUsuarioByIdFuncionario($idFuncionario);

            $result = $this->select('*')
                ->join('users', 'funcionario.id_usuario', '=', 'users.id')
                ->where('users.id', $idUsuario)
                ->get()
                ->toArray();
            if (count($result) > 1) {
                DB::table('funcionario')->where('id', $idFuncionario)->delete();
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function alterar($request)
    {
        $ar = $request->all();

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

        if (!empty(array_filter($request->expediente))) {
            DB::table('horario_trabalho')
                ->where('id_usuario', '=', $request->id)
                ->update(array_filter($request->expediente));
        }
        unset($ar['expediente']);

        if (!empty($request->nome) || !empty($request->numero)) {
            $ar = array_filter($ar);
            DB::table('users')
                ->where('id', '=', $request->id)
                ->update($ar);
        }

        return true;
    }
}
