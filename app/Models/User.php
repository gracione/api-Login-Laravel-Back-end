<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_estabelecimento',
        'nome',
        'numero',
        'tipo_usuario',
        'id_sexo',
        'email',
        'password',
        'id_google',
        'img_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function listar($request)
    {
        $result = DB::table('users')
            ->select('*')
            ->where('id','!=',$request->id_usuario)
            ->get()->toArray();

        return $result;
    }

    public function alterar($request)
    {
        try {
            $ar['nome'] = !empty($request->nome) ? $request->nome : null;
            $ar['numero'] = !empty($request->numero) ? $request->numero : null;
            $ar['password'] = !empty($request->senha) ? Hash::make($request->senha) : null;
            $ar['email'] = !empty($request->email) ? $request->email : null;

            DB::table('users')
                ->where('id', $request->id)
                ->update(array_filter($ar));
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
