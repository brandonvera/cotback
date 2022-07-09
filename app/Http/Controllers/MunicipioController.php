<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Municipio;

class MunicipioController extends Controller
{
    public function index()
    {
        $municipio = Municipio::with(
            'UsuarioCreador',
            'UsuarioModificador',
        )->where(['estado' => 'ACTIVO'])->get();

        return response()->json(compact('municipio'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre" => "required|string|unique:municipios",
            "estado" => "string|in:ACTIVO,INACTIVO",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $municipio = new Municipio();
        $municipio->nombre = $request->nombre;
        $request->estado == null ? $user->estado = "ACTIVO" : $user->estado = $request->estado;
        $municipio->usuario_creacion = $usuario->id;
        $municipio->usuario_modificacion = $usuario->id;
        
        $municipio->save();

        return response()->json(compact('municipio'),201);
    }

    public function show($id)
    {
         $municipio = Municipio::with(
            'UsuarioCreador',
            'UsuarioModificador',
        )->find($id);

        return response()->json(compact('municipio'), 200);
    }
}
