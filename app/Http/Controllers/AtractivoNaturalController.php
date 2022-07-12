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
    private $filtro;

    public function index(Request $request, $id)
    {
        $this->filtro = $request->buscador;
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $naturalTodo = AtractivoNatural::with(
                'UsuarioCreador',
                'UsuarioModificador',
                'Municipio',
            )
            ->where('id_municipio', $id)
            ->where(function ($query) {
                $query
                ->where('nombre', 'LIKE', '%'.$this->filtro.'%')
                ->orWhere('estado', 'LIKE', $this->filtro.'%');
            })->get(); 

            return response()->json(compact('naturalTodo'),200); 
        }

        $natural = AtractivoNatural::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
        )->where([
            'estado' => 'ACTIVO', 
            'id_municipio' => $id
        ])
        ->where('nombre', 'LIKE', '%'.$filtro.'%')
        ->get();

        return response()->json(compact('natural'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $validator = Validator::make($request->all(), [
                "nombre" => "required|string|unique:atractivo_naturals",
                "direccion" => "nullable|string|max:1000",
                "estado" => "required|string|in:ACTIVO,INACTIVO",
                "id_municipio" => "required|integer",
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
    }

    public function show($id)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $natural = AtractivoNatural::with(
                'UsuarioCreador',
                'UsuarioModificador',
                'Municipio',
            )->find($id);

            return response()->json(compact('natural'), 200);
        }
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $validator = Validator::make($request->all(), [
                "nombre" => "string",
                "direccion" => "nullable|string|max:1000",
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
    }

    public function destroy($id)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $natural = AtractivoNatural::find($id);
            $natural->estado = 'INACTIVO';
            $natural->save();

            return response()->json(compact('natural'), 200);
        }
    }

    public function exportNaturales()
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
           return Excel::download(new NaturalesExport, 'AtractivosNaturales.xlsx'); 
        }    
    }

    public function importNaturales(Request $request) 
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
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
}
