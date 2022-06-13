<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlimentoController;
use App\Http\Controllers\HospedajeController;
use App\Http\Controllers\RecreacionController;
use App\Http\Controllers\TransporteController;
use App\Http\Controllers\AtractivoCulturalController;
use App\Http\Controllers\AtractivonaturalController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\RepresentanteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

	//rutas de usuario
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthControllerr@refresh');
    
    Route::get('usuario', [AuthController::class, 'index']);
    Route::get('usuario/{id}', [AuthController::class, 'show']);
    Route::post('usuario/crear', 'App\Http\Controllers\AuthController@store');
    Route::put('usuario/modificar/{id}', [AuthController::class, 'modificar']);
    Route::delete('usuario/eliminar/{id}', [AuthController::class, 'destroy']);

    //rutas de municipios
    Route::get('municipio', [MunicipioController::class, 'index']);
    Route::get('municipio/{id}', [MunicipioController::class, 'show']);
    Route::post('municipio/crear', [MunicipioController::class, 'store']);
    Route::put('municipio/modificar/{id}', [MunicipioController::class, 'update']);
    Route::delete('municipio/eliminar/{id}', [MunicipioController::class, 'destroy']);

    //rutas de representantes
    Route::get('representante', [RepresentanteController::class, 'index']);
    Route::get('representante/{id}', [RepresentanteController::class, 'show']);
    Route::post('representante/crear', [RepresentanteController::class, 'store']);
    Route::put('representante/modificar/{id}', [RepresentanteController::class, 'update']);
    Route::delete('representante/eliminar/{id}', [RepresentanteController::class, 'destroy']);

    //rutas de alimentos
    Route::get('alimento', [AlimentoController::class, 'index']);
    Route::get('alimento/{id}', [AlimentoController::class, 'show']);
    Route::post('alimento/crear', [AlimentoController::class, 'store']);
    Route::put('alimento/modificar/{id}', [AlimentoController::class, 'update']);
    Route::delete('alimento/eliminar/{id}', [AlimentoController::class, 'destroy']);

    //rutas de hospedaje
    Route::get('hospedaje', [HospedajeController::class, 'index']);
    Route::get('hospedaje/{id}', [HospedajeController::class, 'show']);
    Route::post('hospedaje/crear', [HospedajeController::class, 'store']);
    Route::put('hospedaje/modificar/{id}', [HospedajeController::class, 'update']);
    Route::delete('hospedaje/eliminar/{id}', [HospedajeController::class, 'destroy']);

    //rutas de recreacion
    Route::get('recreacion', [RecreacionController::class, 'index']);
    Route::get('recreacion/{id}', [RecreacionController::class, 'show']);
    Route::post('recreacion/crear', [RecreacionController::class, 'store']);
    Route::put('recreacion/modificar/{id}', [RecreacionController::class, 'update']);
    Route::delete('recreacion/eliminar/{id}', [RecreacionController::class, 'destroy']);

    //rutas de transporte
    Route::get('transporte', [TransporteController::class, 'index']);
    Route::get('transporte/{id}', [TransporteController::class, 'show']);
    Route::post('transporte/crear', [TransporteController::class, 'store']);
    Route::put('transporte/modificar/{id}', [TransporteController::class, 'update']);
    Route::delete('transporte/eliminar/{id}', [TransporteController::class, 'destroy']);

    //rutas de atractivo cultural
    Route::get('cultural', [AtractivoCulturalController::class, 'index']);
    Route::get('cultural/{id}', [AtractivoCulturalController::class, 'show']);
    Route::post('cultural/crear', [AtractivoCulturalController::class, 'store']);
    Route::put('cultural/modificar/{id}', [AtractivoCulturalController::class, 'update']);
    Route::delete('cultural/eliminar/{id}', [AtractivoCulturalController::class, 'destroy']);

    //rutas de atractivo natural
    Route::get('natural', [AtractivoNaturalController::class, 'index']);
    Route::get('natural/{id}', [AtractivoNaturalController::class, 'show']);
    Route::post('natural/crear', [AtractivoNaturalController::class, 'store']);
    Route::put('natural/modificar/{id}', [AtractivoNaturalController::class, 'update']);
    Route::delete('natural/eliminar/{id}', [AtractivoNaturalController::class, 'destroy']);



});
