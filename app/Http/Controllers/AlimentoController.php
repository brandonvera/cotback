<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Alimento;
use App\Exports\AlimentosExport;
use App\Imports\AlimentosImport;

class AlimentoController extends Controller
{
    private $filtro;

    public function index(Request $request, $id)
    {  
        $usuario = auth()->user();
        $this->filtro = $request->buscador;

        if($usuario->id == 1)
        {    
            $alimentoTodo = Alimento::with(
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

            return response()->json(compact('alimentoTodo'),200);
        }

        $alimento = Alimento::with(
            'UsuarioCreador',
            'UsuarioModificador',
            'Municipio',
            'Representante',
        )
        ->where([
            'estado' => 'ACTIVO', 
            'id_municipio' => $id
        ])
        ->where('razon_social', 'LIKE', '%'.$this->filtro.'%')
        ->get();

        return response()->json(compact('alimento'),200);
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $validator = Validator::make($request->all(), [
                "razon_social" => "required|string|unique:alimentos",
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
    }

    public function show($id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $alimento = Alimento::with(
                'UsuarioCreador',
                'UsuarioModificador',
                'Municipio',
                'Representante',
            )->find($id);

            return response()->json(compact('alimento'), 200);
        }
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
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
            $alimento->save();

            return response()->json(compact('alimento'), 200);
        }
    }

    public function destroy($id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $alimento = Alimento::find($id);
            $alimento->estado = 'INACTIVO';
            $alimento->save();

            return response()->json(compact('alimento'), 200);
        }
    }

    public function exportAlimentos()
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            return Excel::download(new AlimentosExport, 'Alimentos.xlsx');
        }
    }

    public function importAlimentos(Request $request) 
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            try 
            {
                set_time_limit(300);
                Excel::import(new AlimentosImport, $request->file('data'));

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
