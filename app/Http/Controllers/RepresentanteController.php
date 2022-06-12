<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Representante;

class RepresentanteController extends Controller
{
    public function index()
    {
        $representante = Representante::with(
            'UsuarioCreador',
            'UsuarioModificador',
        )->where(['estado' => 'ACTIVO'])->get(); 

        return response()->json(compact('representante'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre" => "required|string",
            "apellido" => "required|string",
            "cargo" => "required|string",
            "telefono" => "string",
            "correo" => "string|email|max:100",
            "direccion" => "string|max:1000",
            "estado" => "string|in:ACTIVO,INACTIVO",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $representante = new Representante();
        $representante->nombre = $request->nombre;
        $representante->apellido = $request->apellido;
        $representante->cargo = $request->cargo;
        $representante->telefono = $request->telefono;
        $representante->correo = $request->correo;
        $representante->direccion = $request->direccion;
        $request->estado == null ? $representante->estado = "ACTIVO" : $representante->estado = $request->estado;
        $representante->usuario_creacion = $usuario->id;
        $representante->usuario_modificacion = $usuario->id;
        
        $representante->save();

        return response()->json(compact('representante'),201);
    }

    public function show($id)
    {
        $representante = Representante::with(
            'UsuarioCreador',
            'UsuarioModificador', 
        )->find($id);

        return response()->json(compact('representante'), 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre" => "string",
            "apellido" => "string",
            "cargo" => "string",
            "telefono" => "string",
            "correo" => "string|email|max:100",
            "direccion" => "string|max:1000",
            "estado" => "string|in:ACTIVO,INACTIVO",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $representante = Representante::find($id);
        $representante->nombre = $request->nombre;
        $representante->apellido = $request->apellido;
        $representante->cargo = $request->cargo;
        $representante->telefono = $request->telefono;
        $representante->correo = $request->correo;
        $representante->direccion = $request->direccion;
        $request->estado == null ? $representante->estado = "ACTIVO" : $representante->estado = $request->estado;
        $representante->usuario_creacion = $usuario->id;
        $representante->usuario_modificacion = $usuario->id;
        
        $representante->update();

        return response()->json(compact('representante'), 200);
    }

    public function destroy($id)
    {
        $representante = Representante::find($id);
        $representante->estado = 'INACTIVO';
        $representante->save();

        return response()->json(compact('representante'), 200);
    }
}