<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use Illuminate\Http\Request;

class MensagemController extends Controller
{
    public function index()
    {
        $mensagens = Mensagem::all();

        return response()->json($mensagens);
    }

    public function listar($id)
    {
        $mensagem = Mensagem::find($id);

        if (!$mensagem) {
            return response()->json(['message' => 'Mensagem não encontrada'], 404);
        }

        return response()->json($mensagem);
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'remetente_id' => 'required',
            'conteudo' => 'required',
        ]);

        $mensagem = Mensagem::create($request->all());

        
        return response()->json($mensagem, 201);
    }

    public function alterar(Request $request, $id)
    {
        $mensagem = Mensagem::find($id);

        if (!$mensagem) {
            return response()->json(['message' => 'Mensagem não encontrada'], 404);
        }

        $mensagem->update($request->all());

        return response()->json($mensagem);
    }

    public function excluir($id)
    {
        $mensagem = Mensagem::find($id);

        if (!$mensagem) {
            return response()->json(['message' => 'Mensagem não encontrada'], 404);
        }

        $mensagem->delete();

        return response()->json(['message' => 'Mensagem excluída com sucesso']);
    }
}
