<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Galeria;
use App\Models\Imagens;
use Illuminate\Support\Facades\App;

class GaleriaController extends Controller
{
    public $galeria;

    public function __construct()
    {
        $this->galeria = new Galeria();
    }

    public function listar()
    {
        return $this->galeria->listar();
    }

    public function fotosAlbum(Request $request)
    {
        return $this->galeria->fotosAlbum($request);
    }
    public function uploadFoto(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');
        $publicPath = public_path('/perfil');
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move($publicPath, $imageName);

//        $idUsuario = auth()->user()->id;
        $imagens = new Imagens();
        $publicPath = public_path('perfil/' . $imageName);

        if (file_exists($publicPath)) {
            $imageContent = file_get_contents($publicPath);
            $imageData = base64_encode($imageContent);
            $imageSrc = 'data:image/' . pathinfo($publicPath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
        }
        $imagens->album_id = $request->idAlbum;
        $imagens->nome_arquivo = $imageSrc;
        $imagens->descricao = 'teste';
        $imagens->save();
        return $imageSrc;
    }
    public function inserir(Request $request)
    {
        return $this->galeria->inserir($request);
    }

    public function destroy(Request $request)
    {
        $galeria = $this->galeria->find($request->id);
        return $galeria->delete($request->id);
    }

    public function alterar(Request $request)
    {
        try {
            $this->galeria->alterar($request);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
