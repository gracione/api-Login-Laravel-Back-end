<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';

    protected $fillable = [
        'ds_nome',
        'ds_numero',
        'id_usuario',
        'id_sexo',

    ];
}
