<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Folgas extends Model
{
    use HasFactory;

    public function listar ($request) {
        $select = DB::table('folgas')
        ->select('*')
        ->get();
        return $select;
    }

}
