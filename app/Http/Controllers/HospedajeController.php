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
    private $filtro;

    public function index(Request $request, $id)
    {
        $this->filtro = $request->buscador;
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $hospedajeTodo = Hospedaje::with(
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

            return response()->json(compact('hospedajeTodo'),200);  
        }

        $hospedaje = Hospedaje::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
            'Representante',
        )->where([
            'estado' => 'ACTIVO', 
            'id_municipio' => $id
        ])
        ->Where('razon_social', 'LIKE', '%'.$this->filtro.'%')
        ->get();

        return response()->json(compact('hospedaje'),200); 
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $validator = Validator::make($request->all(), [
                "razon_social" => "required|string|unique:hospedajes",
                "establecimientos" => "nullable|integer",
                "telefono" => "nullable|string|regex:/[0-9]/|min:11|max:11",      
                "correo" => "nullable|string|email",
                "direccion_principal" => "nullable|string|max:1000",
                "id_municipio" => "required|integer",
                "estado"       => "required|string|in:ACTIVO,INACTIVO",
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
    }

    public function show($id)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $hospedaje = Hospedaje::with(
                'UsuarioCreador',
                'UsuarioModificador',
                'Municipio',
                'Representante',
            )->find($id);

            return response()->json(compact('hospedaje'), 200);
        }
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $validator = Validator::make($request->all(), [
                "razon_social" => "string",
                "establecimientos" => "nullable|integer",
                "telefono" => "nullable|string|regex:/[0-9]/|min:11|max:11",      
                "correo" => "nullable|string|email",
                "direccion_principal" => "nullable|string|max:1000",               
                "id_municipio" => "integer",
                "estado"       => "string|in:ACTIVO,INACTIVO",
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
    }

    public function destroy($id)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $hospedaje = Hospedaje::find($id);
            $hospedaje->estado = 'INACTIVO';
            $hospedaje->save();

            return response()->json(compact('hospedaje'), 200);
        }
    }

    public function exportHospedajes()
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            return Excel::download(new HospedajesExport, 'Hospedajes.xlsx');
        }
    }

    public function importHospedajes(Request $request) 
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
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
}
