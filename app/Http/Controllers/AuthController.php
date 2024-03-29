<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Events\NuevoUsuarioEvent;
use App\Http\Controllers\Controller;
use App\Exports\UsersExport;
use App\Models\User;

class AuthController extends Controller
{
    private $filtro;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = $this->respondWithToken($token);

        $usuario = auth()->user();
        return response()->json(compact('token', 'usuario'), 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Cierre de Sesion Exitoso']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function index(Request $request) 
    {
        $this->filtro = $request->buscador;
        $usuario = auth()->user();    

        if($usuario->id_tipo == 1)
        {
            $user = User::with(
                'TipoUsuario',
                'UsuarioCreador',
                'UsuarioModificador'
            )
            ->Where('codigo', 'LIKE', '%'.$this->filtro.'%')
            ->orWhere('estado', 'LIKE', $this->filtro.'%')
            ->get();

            return response()->json(compact('user'), 200);
        }
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $validator = Validator::make($request->all(), [
                "codigo"   => "required|string|regex:/[COD]/|regex:/[0-9]/|starts_with:COD|min:6|max:6|unique:users",
                "nombre"   => "required|string|max:100",
                "apellido" => "required|string|max:100",
                "email"    => "required|string|email|max:100|unique:users",
                "password" => "required|string|min:6|max:12|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&.]/",
                "estado"   => "required|string|in:ACTIVO,INACTIVO",
                "id_tipo"  => "required|integer",
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            };

            $user = new User();
            $user->codigo = $request->codigo;
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->email = $request->email;
            $pw = $request->password;
            $user->password = Hash::make($request->password);
            $request->estado == null ? $user->estado = "ACTIVO" : $user->estado = $request->estado;
            $request->usuario_creacion == null ? $user->usuario_creacion = $usuario->id : $user->usuario_creacion = $usuario->id;
            $request->usuario_modificacion == null ? $user->usuario_modificacion = $usuario->id : $user->usuario_modificacion = $usuario->id;
            $user->id_tipo = $request->id_tipo;
            $user->save();

            event(new NuevoUsuarioEvent($user, $pw));

            return response()->json(compact('user'),201);
        }
    }

    public function show($id)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $user = User::with(
                'TipoUsuario',
                'UsuarioCreador',
                'UsuarioModificador'
            )->find($id);

            return response()->json(compact('user', 'usuario'), 200);
        }
    }

    public function modificar(Request $request, $id)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            $validator = Validator::make($request->all(), [
                "codigo"   => "string|regex:/[COD]/|regex:/[0-9]/|starts_with:COD|min:6|max:6",
                "nombre"   => "string|max:100",
                "apellido" => "string|max:100",
                "email"    => "string|email|max:100",
                "estado"   => "nullable|string|in:ACTIVO,INACTIVO",
                "id_tipo"  => "integer",
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            };

            $user = User::find($id);

            $request->codigo == null || $request->codigo == "" ? $user->codigo = $user->codigo : $user->codigo = $request->codigo;
            $request->nombre == null || $request->nombre == "" ? $user->nombre = $user->nombre : $user->nombre = $request->nombre;
            $request->apellido == null || $request->apellido == "" ? $user->apellido = $user->apellido : $user->apellido = $request->apellido;
            $request->email == null || $request->email == "" ? $user->email = $user->email : $user->email = $request->email;
            $request->password == null || $request->password == "" ? $user->password = $user->password : $user->password = Hash::make($request->password);

            if($usuario->id != $id){
                if($user->id_tipo != 1){
                    $request->estado == null || $request->estado == "" ? $user->estado = "ACTIVO" : $user->estado = $request->estado;
                }
            }

            $request->usuario_creacion == null ? $user->usuario_creacion = $usuario->id : $user->usuario_creacion = $usuario->id;
            $request->usuario_modificacion == null ? $user->usuario_modificacion = $usuario->id : $user->usuario_modificacion = $usuario->id;

            if($usuario->id != $id){
                if($user->id_tipo != 1){
                    $request->id_tipo == null ? $user->id_tipo = $user->id_tipo : $user->id_tipo = $request->id_tipo;
                }
            }

            $user->update();

            return response()->json(compact('user'),200);
        }
    }

    public function destroy($id)
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            if($usuario->id != $id)
            {            
                $usser = User::find($id);

                if($usser->id_tipo != 1)
                {
                    $usser->estado = "INACTIVO";
                    $usser->update();

                    return response()->json(compact('usser'), 200); 
                }
                else 
                {
                    return response()->json('e', 400);
                }    
            }
            else 
            {
                return response()->json('e', 400);
            }
        }
    }

    public function exportUser()
    {
        $usuario = auth()->user();

        if($usuario->id_tipo == 1)
        {
            return Excel::download(new UsersExport, 'Usuarios.xlsx');  
        }    
    }
}