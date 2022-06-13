<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Municipio;

class MunicipioController extends Controller
{
    public function index()
    {
        $municipio = Municipio::select(
            'nombre',
            'estado'
        )->with(
            'UsuarioCreador',
            'UsuarioModificador',
        )where(
            ['estado' => 'ACTIVO']
        )->get(); 

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
         $municipio = Municipio::select(
            'nombre',
            'estado'
        )->with(
            'UsuarioCreador',
            'UsuarioModificador',
        )where(
            ['id' => $id]
        )->get();

        return response()->json(compact('municipio'), 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre" => "string",
            "estado" => "string|in:ACTIVO,INACTIVO",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $municipio = Municipio::find($id);
        $municipio->nombre = $request->nombre;
        $request->estado == null || $request->estado == "" ? $user->estado = "ACTIVO" : $user->estado = $request->estado;
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
