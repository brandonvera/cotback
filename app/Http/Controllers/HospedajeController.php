<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Hospedaje;
use App\Exports\HospedajesExport;
use App\Imports\HospedajesImport;

class HospedajeController extends Controller
{
    public function index()
    {
        $hospedaje = Hospedaje::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
            'Representante',
        )->where(['estado' => 'ACTIVO'])->get(); 

        return response()->json(compact('hospedaje'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "razon_social"        => "required|string|unique:hospedajes",
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

        $hospedaje = new Hospedaje;
        $hospedaje->razon_social = $request->razon_social;
        $hospedaje->establecimientos = $request->establecimientos;
        $hospedaje->telefono = $request->telefono;
        $hospedaje->correo = $request->correo;
        $hospedaje->direccion_principal = $request->direccion_principal;
        $request->estado == null ? $hospedaje->estado = "ACTIVO" : $hospedaje->estado = $request->estado;
        $hospedaje->usuario_creacion = $usuario->id;
        $hospedaje->id_municipio = $request->id_municipio;
        $request->id_representantes == null ? $hospedaje->id_representantes = null : $hospedaje->id_representantes = $request->id_representantes;
        $hospedaje->save();

        return response()->json(compact('hospedaje'),201);
    }

    public function show($id)
    {
        $hospedaje = Hospedaje::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
            'Representante',
        )->find($id);

        return response()->json(compact('hospedaje'), 200);
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

        $hospedaje = Hospedaje::find($id);
        $hospedaje->razon_social = $request->razon_social;
        $hospedaje->establecimientos = $request->establecimientos;
        $hospedaje->telefono = $request->telefono;
        $hospedaje->correo = $request->correo;
        $hospedaje->direccion_principal = $request->direccion_principal;
        $request->estado == null ? $hospedaje->estado = "ACTIVO" : $hospedaje->estado = $request->estado;
        $hospedaje->usuario_modificacion = $usuario->id;
        $hospedaje->id_municipio = $request->id_municipio;
        $request->id_representantes == null ? $hospedaje->id_representantes = null : $hospedaje->id_representantes = $request->id_representantes;
        $hospedaje->update();

        return response()->json(compact('hospedaje'), 200);
    }

    public function destroy($id)
    {
        $hospedaje = Hospedaje::find($id);
        $hospedaje->estado = 'INACTIVO';
        $hospedaje->save();

        return response()->json(compact('hospedaje'), 200);
    }

    public function exportHospedajes()
    {
        return Excel::download(new HospedajesExport, 'Hospedajes.xlsx');
    }

    public function importHospedajes(Request $request) 
    {
        try 
        {
            set_time_limit(300);
            Excel::import(new HospedajesImport, $request->file('data'));

            return response()->json('Importe Exitoso', 200);

        } 

        catch (\Maatwebsite\Excel\Validators\ValidationException $e) 
        {
            $failures = $e->failures();

            return response()->json(compact('failures'), 400); 
        }
    }
}
