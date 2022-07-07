<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tratamentos;

class TratamentosController extends Controller
{
    public function listar (Request $request) {
        return Tratamentos::listar($request);
    }
}
