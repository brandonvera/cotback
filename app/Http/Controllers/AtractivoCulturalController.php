<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\AtractivoCultural;
use App\Exports\CulturalesExport;

class AtractivoCulturalController extends Controller
{
    public function index()
    {
        $hospedaje = AtractivoCultural::select(
            'nombre',
            'direccion',
            'estado',
        )->with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
        )->where(['estado' => 'ACTIVO'])->get(); 

        return response()->json(compact('cultural'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre"       => "required|string|unique:atractivo_culturals",
            "direccion"    => "string|max:1000",
            "estado"       => "string|in:ACTIVO,INACTIVO",
            "id_municipio" => "integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $cultural = new AtractivoCultural();
        $cultural->nombre = $request->nombre;
        $cultural->direccion = $request->direccion;
        $request->estado == null ? $cultural->estado = "ACTIVO" : $cultural->estado = $request->estado;
        $cultural->usuario_creacion = $usuario->id;
        $cultural->usuario_modificacion = $usuario->id;
        $cultural->id_municipio = $request->id_municipio;
        $cultural->save();

        return response()->json(compact('cultural'),201);
    }

    public function show($id)
    {
        $hospedaje = AtractivoCultural::select(
            'nombre',
            'direccion',
            'estado',
        )->with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
        )->where(['estado' => $id])->get();

        return response()->json(compact('cultural'), 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre"       => "string",
            "direccion"    => "string|max:1000",
            "estado"       => "string|in:ACTIVO,INACTIVO",
            "id_municipio" => "integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        };

        $cultural = AtractivoCultural::find($id);
        $cultural->nombre = $request->nombre;
        $cultural->direccion = $request->direccion;
        $request->estado == null ? $cultural->estado = "ACTIVO" : $cultural->estado = $request->estado;
        $cultural->usuario_creacion = $usuario->id;
        $cultural->usuario_modificacion = $usuario->id;
        $cultural->id_municipio = $request->id_municipio;
        $cultural->update();

        return response()->json(compact('cultural'), 200);
    }

    public function destroy($id)
    {
        $cultural = AtractivoCultural::find($id);
        $cultural->estado = 'INACTIVO';
        $cultural->save();

        return response()->json(compact('cultural'), 200);
    }

    public function exportCulturales()
    {
        return Excel::download(new CulturalesExport, 'AtractivosCulturales.xlsx');
    }
}
