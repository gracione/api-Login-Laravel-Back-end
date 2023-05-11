<?php

namespace App\Models;

use Exception;
use Funcionario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profissao extends Model
{
    protected $table = 'profissao';

    public function listar()
    {
        return $this->select('nome as profissão', 'id')->get()->toArray();

    }

    public function getById($request)
    {
        return $this->select('nome')->where('id', $request->id)->get()->toArray();
    }

    public function getByIdFuncionario($request)
    {
        return $this->select('nome', 'id', 'funcionario.id_usuario', 'funcionario.id as id_funcionario')
            ->join('funcionario', 'funcionario.id_profissao', '=', 'profissao.id')
            ->where('funcionario.id_usuario', $request->id)
            ->get()->toArray();
    }
    public function excluir($request)
    {
        try {
            $this->where('id', $request->id)->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function alterar($request)
    {
        if (!empty($request->nome)) {
            $this->where('id', $request->id)->update(['nome' => $request->nome]);
            return true;
        }
        return false;
    }

    public function inserir($request)
    {
        $this->nome = $request->nome;
        $this->save();
        return 'inserido';
    }
}
