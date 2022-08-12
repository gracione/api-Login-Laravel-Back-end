<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feriado;

class FeriadoController extends Controller
{
    public function listar () {
        return Feriado::listar();
    }
}
