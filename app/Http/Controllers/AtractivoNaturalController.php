<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\AtractivoNatural;
use App\Exports\NaturalesExport;
use App\Imports\NaturalesImport;

class AtractivoNaturalController extends Controller
{
    public function index(Request $request, $id)
    {
        $filtro = $request->buscador;

        $natural = AtractivoNatural::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
        )->where([
            'estado' => 'ACTIVO', 
            'id_municipio' => $id
        ])->get();

        $naturalTodo = AtractivoNatural::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
        )->where([ 
            'id_municipio' => $id
        ])
        ->Where('nombre', 'LIKE', '%'.$filtro.'%')
        ->get(); 

        return response()->json(compact('natural', 'naturalTodo'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            "nombre"       => "required|string|unique:atractivo_naturals",
            "direccion"    => "string|max:1000",
            "estado"       => "string|in:ACTIVO,INACTIVO",
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
            "nombre"       => "string",
            "direccion"    => "string|max:1000",
            "estado"       => "string|in:ACTIVO,INACTIVO",
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

    public function exportNaturales()
    {
        return Excel::download(new NaturalesExport, 'AtractivosNaturales.xlsx');
    }

    public function importNaturales(Request $request) 
    {
        try 
        {
            set_time_limit(300);
            Excel::import(new NaturalesImport, $request->file('data'));

            return response()->json('Importe Exitoso', 200);

        } 

        catch (\Maatwebsite\Excel\Validators\ValidationException $e) 
        {
            $failures = $e->failures();

            return response()->json(compact('failures'), 400); 
        }
    }
}
