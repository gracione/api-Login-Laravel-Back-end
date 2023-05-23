<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Configuracao extends Model
{
    use HasFactory;

    protected $table = 'configuracao'; // Assuming the table name is 'configuracao'

    public static function getAllConfiguracoes()
    {
        try {
            $configuracao = Configuracao::first();
            return $configuracao ? $configuracao->toArray() : [];
        } catch (Exception $e) {
            // Trate a exceção, se necessário
            return [];
        }
    }

    public function alterar($request)
    {
        foreach ($request->request as $key => $value) {
            if ($value) {
                $ar[$key] = $value;
            }
        }

        DB::table('configuracao')
            ->update(array_filter($ar));

        return true;
    }

}
