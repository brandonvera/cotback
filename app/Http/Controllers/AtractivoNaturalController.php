<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\AtractivoNatural;

class AtractivoNaturalController extends Controller
{
    public function index()
    {
        $natural = AtractivoNatural::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
        )->where(['estado' => 'ACTIVO'])->get(); 

        return response()->json(compact('natural'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre" => "required|string|unique:atractivo_naturals",
            "direccion" => "string|max:1000",
            "estado" => "string|in:ACTIVO,INACTIVO",
            "id_municipio" => "integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $natural = new AtractivoNatural();
        $natural->nombre = $request->nombre;
        $natural->direccion = $request->direccion;
        $request->estado == null ? $natural->estado = "ACTIVO" : $natural->estado = $request->estado;
        $natural->usuario_creacion = $usuario->id;
        $natural->usuario_modificacion = $usuario->id;
        $natural->id_municipio = $request->id_municipio;
        $natural->save();

        return response()->json(compact('natural'),201);
    }

    public function show($id)
    {
        $natural = AtractivoNatural::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio', 
        )->find($id);

        return response()->json(compact('natural'), 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre" => "string",
            "direccion" => "string|max:1000",
            "estado" => "string|in:ACTIVO,INACTIVO",
            "id_municipio" => "integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $natural = AtractivoNatural::find($id);
        $natural->nombre = $request->nombre;
        $natural->direccion = $request->direccion;
        $request->estado == null ? $natural->estado = "ACTIVO" : $natural->estado = $request->estado;
        $natural->usuario_creacion = $usuario->id;
        $natural->usuario_modificacion = $usuario->id;
        $natural->id_municipio = $request->id_municipio;
        $natural->update();

        return response()->json(compact('natural'), 200);
    }

    public function destroy($id)
    {
        $natural = AtractivoNatural::find($id);
        $natural->estado = 'INACTIVO';
        $natural->save();

        return response()->json(compact('natural'), 200);
    }
}
