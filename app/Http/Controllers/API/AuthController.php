<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use App\Traits\ApiResponser;
use App\Http\Controllers\API\Constantes;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function registrarCliente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'id_sexo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = User::create([
            'nome' => $request->nome,
            'numero' => $request->numero,
            'tipo_usuario' => '3',
            'id_sexo' => $request->id_sexo,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        DB::table('cliente')->insert([
            'id_usuario' => $user['id']
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['tipo_usuario' => $user['tipo_usuario'], 'nome' => $user['nome'], 'id_usuario' => $user['id'], 'data' => $user, 'token' => $token, 'token_type' => 'Bearer',]);
    }

    public function login(Request $request)
    {
        if(!empty($request['googleId'])){
            $idGoogle = $request['googleId'];
//            $userGoogle = User::where('id_google', $idGoogle)->firstOrFail();

            $userGoogle = DB::table('users')
            ->where('id_google', $idGoogle)
            ->get();

            if (empty($userGoogle['0']->email)) {
                $user = User::create([
                    'nome' => $request['name'],
                    'numero' => '23',
                    'tipo_usuario' => '3',
                    'id_sexo' => 3,
                    'email' => $request['email'],
                    'password' => Hash::make('123'),
                    'id_google' => $idGoogle,
                    'img_url' => $request['imageUrl']
                ]);
        
                DB::table('cliente')->insert([
                    'id_usuario' => $user['id']
                ]);
        
                $token = $user->createToken('auth_token')->plainTextToken;
        
                return response()->json(['tipo_usuario' => $user['tipo_usuario'], 'nome' => $user['nome'], 'id_usuario' => $user['id'], 'data' => $user,'img_url' => $user['img_url'], 'token' => $token, 'token_type' => 'Bearer',]);        
            }
        } else if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['tipo_usuario' => $user['tipo_usuario'], 'nome' => $user['nome'], 'id_usuario' => $user['id'],'img_url' => $user['img_url'], 'token' => $token]);
    }

    public function dadosConfiguracao(Request $request)
    {
        return auth()->user();
    }

    public function sair()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Você saiu com sucesso e o token foi excluído com sucesso'
        ];
    }

    public function alterar(Request $request)
    {
        return User::alterar($request);
    }
}
