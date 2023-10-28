<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Util;

class Folgas extends Model
{
    use HasFactory;
    protected $table = 'folga';
    public $timestamps = false;
    protected $fillable = ['dia_semana' ,'id_funcionario' ,'id_usuario'];

    public function listar()
    {
        return DB::table('folga')
            ->join('funcionario', 'funcionario.id', '=', 'folga.id_funcionario')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id')
            ->join('users', 'users.id', '=', 'funcionario.id_usuario')
            ->join('semana', 'semana.id', '=', 'folga.dia_semana')
            ->select(
                'users.nome as funcionario',
                'semana.nome as folga',
                'folga.id as id',
                'folga.dia_semana as dia_semana',
                'profissao.nome as profissao'
            )
            ->get()
            ->toArray();
    }

    public function getById($request)
    {
        return DB::table('folga')
            ->join('funcionario', 'funcionario.id', '=', 'folga.id_funcionario')
            ->join('profissao', 'funcionario.id_profissao', '=', 'profissao.id')
            ->join('users', 'users.id', '=', 'funcionario.id_usuario')
            ->join('semana', 'semana.id', '=', 'folga.dia_semana')
            ->select(
                'users.nome as funcionario',
                'semana.nome as folga',
                'folga.id as id',
                'folga.dia_semana as dia_semana',
                'profissao.nome as profissao'
            )
            ->where('folga.id', $request->id)
            ->get();
    }

    public function getByIdFuncionario($request)
    {
        $idFuncionario = $request->dados['idFuncionario'];
        $select = DB::table('folga')
            ->select('dia_semana')
            ->where('id_funcionario', $idFuncionario)
            ->get();
        $results = $select->toArray();

        $arr = [];
        foreach ($results as $value) {
            $arr[] = $value->dia_semana;
        }
        return $arr;
    }

    public function verificarFolga($request)
    {
        $diaSemana = date('w', strtotime($request->data)) + 1;
        $idFuncionario = $request->idFuncionario;

        $select = DB::table('folga')
            ->select('dia_semana')
            ->where('dia_semana', $diaSemana)
            ->where('id_funcionario', $idFuncionario)
            ->get();
        $results = $select->toArray();

        return !empty($results[0]) ? true : false;
    }

    public function inserir($request)
    {
        $dados = Util::splitByHashtag($request->dados);

        DB::table('folga')->insert([
            'dia_semana' => $request->diaSemana,
            'id_funcionario' => $dados[0],
            'id_usuario' => $dados[1]
        ]);

        return true;
    }

    public function alterar($request)
    {
        $ar['dia_semana'] = $request->diaSemana;

        DB::table('folga')
            ->where('id', $request->id)
            ->update(array_filter($ar));

        return true;
    }
}
