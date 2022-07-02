<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoUsuario;

class TipoUsuarioController extends Controller
{
    public function index() 
    {
        $rol = TipoUsuario::all();

        return response()->json(compact('rol'), 200);
    }
}
