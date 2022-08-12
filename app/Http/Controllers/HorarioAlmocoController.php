<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorarioAlmoco;

class HorarioAlmocoController extends Controller
{
    public function listar () {
        return HorarioAlmoco::listar();
    }
}
