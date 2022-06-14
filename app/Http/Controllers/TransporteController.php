<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Transporte;
use App\Exports\TransportesExport;

class TransporteController extends Controller
{
    public function index()
    {
        $hospedaje = Transporte::select(
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

        return response()->json(compact('transporte'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "razon_social"        => "required|string|unique:transportes",
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

        $transporte = new Transporte();
        $transporte->razon_social = $request->razon_social;
        $transporte->establecimientos = $request->establecimientos;
        $transporte->telefono = $request->telefono;
        $transporte->correo = $request->correo;
        $transporte->direccion_principal = $request->direccion_principal;
        $request->estado == null ? $transporte->estado = "ACTIVO" : $transporte->estado = $request->estado;
        $transporte->usuario_creacion = $usuario->id;
        $transporte->id_municipio = $request->id_municipio;
        $request->id_representantes == null ? $transporte->id_representantes = null : $transporte->id_representantes = $request->id_representantes;
        $transporte->save();

        return response()->json(compact('transporte'),201);
    }

    public function show($id)
    {
        $hospedaje = Transporte::select(
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

        return response()->json(compact('transporte'), 200);
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

        $transporte = Transporte::find($id);
        $transporte->razon_social = $request->razon_social;
        $transporte->establecimientos = $request->establecimientos;
        $transporte->telefono = $request->telefono;
        $transporte->correo = $request->correo;
        $transporte->direccion_principal = $request->direccion_principal;
        $request->estado == null ? $transporte->estado = "ACTIVO" : $transporte->estado = $request->estado;
        $transporte->usuario_modificacion = $usuario->id;
        $transporte->id_municipio = $request->id_municipio;
        $request->id_representantes == null ? $transporte->id_representantes = null : $transporte->id_representantes = $request->id_representantes;
        $transporte->update();

        return response()->json(compact('transporte'), 200);
    }

    public function destroy($id)
    {
        $transporte = Transporte::find($id);
        $transporte->estado = 'INACTIVO';
        $transporte->save();

        return response()->json(compact('transporte'), 200);
    }

    public function exportTransportes()
    {
        return Excel::download(new TransportesExport, 'transportes.xlsx');
    }
}
