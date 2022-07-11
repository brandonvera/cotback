<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Transporte;
use App\Exports\TransportesExport;
use App\Imports\TransportesImport;

class TransporteController extends Controller
{
    private $filtro;

    public function index(Request $request, $id)
    {
        $this->filtro = $request->buscador;
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $transporteTodo = Transporte::with(
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

            return response()->json(compact('transporteTodo'),200);
        }

        $transporte = Transporte::with(
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

        return response()->json(compact('transporte'),200);
    }

    public function store(Request $request)
    { 
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $validator = Validator::make($request->all(), [
                "razon_social" => "required|string|unique:transportes",
                "estado"       => "required|string|in:ACTIVO,INACTIVO",
                "id_municipio" => "required|integer",
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
    }

    public function show($id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $transporte = Transporte::with(
                'UsuarioCreador',
                'UsuarioModificador',
                'Municipio',
                'Representante',
            )->find($id);

            return response()->json(compact('transporte'), 200);
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
    }

    public function destroy($id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $transporte = Transporte::find($id);
            $transporte->estado = 'INACTIVO';
            $transporte->save();

            return response()->json(compact('transporte'), 200);
        }
    }

    public function exportTransportes()
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            return Excel::download(new TransportesExport, 'Transportes.xlsx');
        }
    }

    public function importTransportes(Request $request) 
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            try 
            {
                set_time_limit(300);
                Excel::import(new TransportesImport, $request->file('data'));

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
