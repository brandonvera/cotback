<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Recreacion;
use App\Exports\RecreacionesExport;
use App\Imports\RecreacionesImport;

class RecreacionController extends Controller
{
    private $filtro;
    
    public function index(Request $request, $id)
    {
        $this->filtro = $request->buscador;
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $recreacionTodo = Recreacion::with(
                'UsuarioCreador',
                'UsuarioModificador',
                'Municipio',
                'Representante',
            )
            ->where('id_municipio', $id)
            ->where(function ($query) {
                $query
                ->where('razon_social', 'LIKE', '%'.$this->filtro.'%')
                ->orWhere('estado', 'LIKE', $this->filtro.'%');
            })->get(); 

            return response()->json(compact('recreacionTodo'),200);
        }

        $recreacion = Recreacion::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
            'Representante',
        )->where([
            'estado' => 'ACTIVO', 
            'id_municipio' => $id
        ])
        ->Where('razon_social', 'LIKE', '%'.$filtro.'%')
        ->get();

        return response()->json(compact('recreacion'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $validator = Validator::make($request->all(), [
                "razon_social" => "required|string|unique:recreacions",
                "estado"       => "required|string|in:ACTIVO,INACTIVO",
                "id_municipio" => "required|integer",
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
    }

    public function show($id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $recreacion = Recreacion::with(
                'UsuarioCreador',
                'UsuarioModificador',
                'Municipio',
                'Representante',
            )->find($id);

            return response()->json(compact('recreacion'), 200);
        }
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $validator = Validator::make($request->all(), [
                "razon_social" => "string",
                "estado"       => "string|in:ACTIVO,INACTIVO",
                "id_municipio" => "integer",
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
    }

    public function destroy($id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $recreacion = Recreacion::find($id);
            $recreacion->estado = 'INACTIVO';
            $recreacion->save();

            return response()->json(compact('recreacion'), 200);
        }
    }

    public function exportRecreaciones()
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            return Excel::download(new RecreacionesExport, 'Recreaciones.xlsx');
        }
    }

    public function importRecreaciones(Request $request) 
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            try 
            {
                set_time_limit(300);
                Excel::import(new RecreacionesImport, $request->file('data'));

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
