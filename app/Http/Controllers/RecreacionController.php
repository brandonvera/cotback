<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Recreacion;
use App\Exports\RecreacionesExport;

class RecreacionController extends Controller
{
    public function index()
    {
        $hospedaje = Recreacion::select(
            'razon_social',
            'establecimientos',
            'telefono',
            'correo',
            'direccion_principal',
            'estado'
        )->with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
            'Representante',
        )->where(['estado' => 'ACTIVO'])->get(); 

        return response()->json(compact('recreacion'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "razon_social"        => "required|string|unique:recreacions",
            "establecimientos"    => "required|integer",
            "telefono"            => "string",
            "correo"              => "string|email|max:100",
            "direccion_principal" => "string|max:1000",
            "estado"              => "string|in:ACTIVO,INACTIVO",
            "id_municipio"        => "required|integer",
            "id_representantes"   => "integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $recreacion = new Recreacion();
        $recreacion->razon_social = $request->razon_social;
        $recreacion->establecimientos = $request->establecimientos;
        $recreacion->telefono = $request->telefono;
        $recreacion->correo = $request->correo;
        $recreacion->direccion_principal = $request->direccion_principal;
        $request->estado == null ? $recreacion->estado = "ACTIVO" : $recreacion->estado = $request->estado;
        $recreacion->usuario_creacion = $usuario->id;
        $recreacion->id_municipio = $request->id_municipio;
        $request->id_representantes == null ? $recreacion->id_representantes = null : $recreacion->id_representantes = $request->id_representantes;
        $recreacion->save();

        return response()->json(compact('recreacion'),201);
    }

    public function show($id)
    {
        $hospedaje = Recreacion::select(
            'razon_social',
            'establecimientos',
            'telefono',
            'correo',
            'direccion_principal',
            'estado'
        )->with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
            'Representante',
        )->where(['id' => $id])->get();

        return response()->json(compact('recreacion'), 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "razon_social"        => "string",
            "establecimientos"    => "integer",
            "telefono"            => "string",
            "correo"              => "string|email|max:100",
            "direccion_principal" => "string|max:1000",
            "estado"              => "string|in:ACTIVO,INACTIVO",
            "id_municipio"        => "integer",
            "id_representantes"   => "integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $recreacion = Recreacion::find($id);
        $recreacion->razon_social = $request->razon_social;
        $recreacion->establecimientos = $request->establecimientos;
        $recreacion->telefono = $request->telefono;
        $recreacion->correo = $request->correo;
        $recreacion->direccion_principal = $request->direccion_principal;
        $request->estado == null ? $recreacion->estado = "ACTIVO" : $recreacion->estado = $request->estado;
        $recreacion->usuario_modificacion = $usuario->id;
        $recreacion->id_municipio = $request->id_municipio;
        $request->id_representantes == null ? $recreacion->id_representantes = null : $recreacion->id_representantes = $request->id_representantes;
        $recreacion->update();

        return response()->json(compact('recreacion'), 200);
    }

    public function destroy($id)
    {
        $recreacion = Recreacion::find($id);
        $recreacion->estado = 'INACTIVO';
        $recreacion->save();

        return response()->json(compact('recreacion'), 200);
    }

    public function exportRecreaciones()
    {
        return Excel::download(new RecreacionesExport, 'recreaciones.xlsx');
    }
}
