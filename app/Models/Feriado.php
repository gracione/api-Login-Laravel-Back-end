<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Feriado extends Model
{
    use HasFactory;
    public function listar ($request) {
        $select = DB::table('feriado')
        ->select('*')
        ->get();
        return $select;
    }

}
