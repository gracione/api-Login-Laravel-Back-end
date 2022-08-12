<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Estabelecimento;
use App\Traits\ApiResponser;

class AuthController extends Controller
{
    public function registrarEstabelecimento(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nome' => 'required|string|max:255',
            'nome_estabelecimento' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'nome_estabelecimento' => $request->nome,
            'nome' => $request->nome,
            'numero' => $request->numero,
            'tipo_usuario' => '1',
            'id_sexo' => '1',
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);
         $user = Estabelecimento::create([
            'nome' => $request->nome,
            'id_proprietario' => $request->numero,
         ]);

         
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function registrarCliente(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'id_sexo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'nome_estabelecimento' => '',
            'nome' => $request->name,
            'numero' => $request->numero,
            'tipo_usuario' => '3',
            'id_sexo' => $request->id_sexo,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        if($user['tipo_usuario'] == 1) {
            print("administrativo");
        };
        if($user['tipo_usuario'] == 2) {
            print("funcionario");
        };
        if($user['tipo_usuario'] == 3) {
            print("cliente");
        };

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete(); 

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}