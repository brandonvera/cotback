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
        )->get(); 

        return response()->json(compact('municipio'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre" => "required|string|unique:municipios",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $municipio = new Municipio();
        $municipio->nombre = $request->nombre;
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

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre" => "string",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $municipio = Municipio::find($id);
        $municipio->nombre = $request->nombre;
        $municipio->usuario_creacion = $usuario->id;
        $municipio->usuario_modificacion = $usuario->id;
        
        $municipio->update();

        return response()->json(compact('municipio'), 200);
    }

    public function destroy($id)
    {
        $municipio = Municipio::find($id);
        $municipio->estado = 'INACTIVO';
        $municipio->save();

        return response()->json(compact('municipio'), 200);
    }
}
