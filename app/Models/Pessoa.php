<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;
    protected $table = 'pessoa';

    protected $fillable = [
        'ds_nome',
        'ds_numero',
        'id_usuario',
        'id_sexo',
        'bo_tipo_funcionario',
    ];
}
