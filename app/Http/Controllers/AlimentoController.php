<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Alimento;

class AlimentoController extends Controller
{
    public function index()
    {
        $alimento = Alimento::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
            'Representante',
        )->where(['estado' => 'ACTIVO'])->get(); 

        return response()->json(compact('alimento'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "razon_social" => "required|string|unique:alimentos",
            "establecimientos" => "required|integer",
            "telefono" => "string",
            "correo" => "string|email|max:100",
            "direccion_principal" => "string|max:1000",
            "estado" => "string|in:ACTIVO,INACTIVO",
            "id_municipio" => "required|integer",
            "id_representantes" => "integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $alimento = new Alimento();
        $alimento->razon_social = $request->razon_social;
        $alimento->establecimientos = $request->establecimientos;
        $alimento->telefono = $request->telefono;
        $alimento->correo = $request->correo;
        $alimento->direccion_principal = $request->direccion_principal;
        $request->estado == null ? $alimento->estado = "ACTIVO" : $alimento->estado = $request->estado;
        $alimento->usuario_creacion = $usuario->id;
        $alimento->id_municipio = $request->id_municipio;
        $request->id_representantes == null ? $alimento->id_representantes = null : $alimento->id_representantes = $request->id_representantes;
        $alimento->save();

        return response()->json(compact('alimento'),201);
    }

    public function show($id)
    {
        $alimento = Alimento::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
            'Representante', 
        )->find($id);

        return response()->json(compact('alimento'), 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "razon_social" => "string",
            "establecimientos" => "integer",
            "telefono" => "string",
            "correo" => "string|email|max:100",
            "direccion_principal" => "string|max:1000",
            "estado" => "string|in:ACTIVO,INACTIVO",
            "id_municipio" => "integer",
            "id_representantes" => "integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $alimento = Alimento::find($id);
        $alimento->razon_social = $request->razon_social;
        $alimento->establecimientos = $request->establecimientos;
        $alimento->telefono = $request->telefono;
        $alimento->correo = $request->correo;
        $alimento->direccion_principal = $request->direccion_principal;
        $request->estado == null ? $alimento->estado = "ACTIVO" : $alimento->estado = $request->estado;
        $alimento->usuario_modificacion = $usuario->id;
        $alimento->id_municipio = $request->id_municipio;
        $request->id_representantes == null ? $alimento->id_representantes = null : $alimento->id_representantes = $request->id_representantes;
        $alimento->update();

        return response()->json(compact('alimento'), 200);
    }

    public function destroy($id)
    {
        $alimento = Alimento::find($id);
        $alimento->estado = 'INACTIVO';
        $alimento->save();

        return response()->json(compact('alimento'), 200);
    }
}
