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

    public function listar(Request $request)
    {
        $remetenteId = $request->remetente_id;
        $destinatarioId = $request->destinatario_id;
    
        $mensagens = Mensagem::select('mensagens.*', 'remetente.nome as nome_remetente')
        ->join('users as remetente', 'mensagens.remetente_id', '=', 'remetente.id')
        ->where(function ($query) use ($remetenteId, $destinatarioId) {
            $query->where([
                ['mensagens.remetente_id', $remetenteId],
                ['mensagens.destinatario_id', $destinatarioId],
            ]);
        })
        ->orWhere(function ($query) use ($remetenteId, $destinatarioId) {
            $query->where([
                ['mensagens.remetente_id', $destinatarioId],
                ['mensagens.destinatario_id', $remetenteId],
            ]);
        })
        ->get();
    
        if ($mensagens->isEmpty()) {
            return response()->json(['message' => 'Mensagens não encontradas'], 404);
        }
    
        return response()->json($mensagens);
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

    public function destroy($id)
    {
        $mensagem = Mensagem::find($id);

        if (!$mensagem) {
            return response()->json(['message' => 'Mensagem não encontrada'], 404);
        }

        $mensagem->delete();

        return response()->json(['message' => 'Mensagem excluída com sucesso']);
    }
}
