<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Representante;
use App\Exports\RepresentantesExport;
use App\Imports\RepresentantesImport;

class RepresentanteController extends Controller
{
    private $filtro;

    public function index(Request $request)
    {
        $this->filtro = $request->buscador;
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $representante = Representante::with(
                'UsuarioCreador',
                'UsuarioModificador'
            )
            ->Where('codigo', 'LIKE', '%'.$this->filtro.'%')
            ->orWhere('estado', 'LIKE', $this->filtro.'%')
            ->get(); 

            return response()->json(compact('representante'),200);
        }
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $validator = Validator::make($request->all(), [
                "codigo"   => "required|string|regex:/[COD]/|regex:/[0-9]/|starts_with:COD|min:8|max:8|unique:representantes",
                "persona" => "required|string",
                "telefono" => "nullable|string|regex:/[0-9]/|min:11|max:11",
                "correo" => "nullable|string|email",
                "direccion" => "nullable|string|max:1000",
                "estado"  => "required|string|in:ACTIVO,INACTIVO",
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            };

            $representante = new Representante();
            $representante->codigo = $request->codigo;
            $representante->persona = $request->persona;
            $representante->cargo = $request->cargo;
            $representante->telefono = $request->telefono;
            $representante->correo = $request->correo;
            $representante->direccion = $request->direccion;
            $request->estado == null ? $representante->estado = "ACTIVO" : $representante->estado = $request->estado;
            $representante->usuario_creacion = $usuario->id;
            $representante->usuario_modificacion = $usuario->id;
            
            $representante->save();

            return response()->json(compact('representante'),201);
        }
    }

    public function show($id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $representante = Representante::with(
                'UsuarioCreador',
                'UsuarioModificador'
            )->find($id);

            return response()->json(compact('representante'), 200);
        }
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $validator = Validator::make($request->all(), [
                "codigo"   => "string|regex:/[COD]/|regex:/[0-9]/|starts_with:COD|min:8|max:8",
                "persona" => "string",
                "telefono" => "nullable|string|regex:/[0-9]/|min:11|max:11",
                "correo" => "nullable|string|email",
                "direccion" => "nullable|string|max:1000",
                "estado"  => "string|in:ACTIVO,INACTIVO",
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            };

            $representante = Representante::find($id);
            $representante->codigo = $request->codigo;
            $representante->persona = $request->persona;
            $representante->cargo = $request->cargo;
            $representante->telefono = $request->telefono;
            $representante->correo = $request->correo;
            $representante->direccion = $request->direccion;
            $request->estado == null ? $representante->estado = "ACTIVO" : $representante->estado = $request->estado;
            $representante->usuario_creacion = $usuario->id;
            $representante->usuario_modificacion = $usuario->id;
            
            $representante->update();

            return response()->json(compact('representante'), 200);
        }
    }

    public function destroy($id)
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            $representante = Representante::find($id);
            $representante->estado = 'INACTIVO';
            $representante->save();

            return response()->json(compact('representante'), 200);
        }
    }

    public function exportRepresentantes()
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            return Excel::download(new RepresentantesExport, 'Representantes.xlsx');
        }
    }

    public function importRepresentantes(Request $request) 
    {
        $usuario = auth()->user();

        if($usuario->id == 1)
        {
            try 
            {
                set_time_limit(300);
                Excel::import(new RepresentantesImport, $request->file('data'));

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
