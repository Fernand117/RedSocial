<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsuariosController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('usuario/login', [UsuariosController::class, 'loginUsuario']);
Route::post('usuario/registrar', [UsuariosController::class, 'registrarUsuario']);
Route::post('usuario/crear/perfil', [UsuariosController::class, 'crearPerfil']);
Route::post('usuario/editar/perfil', [UsuariosController::class, 'editarPerfil']);
Route::post('usuario/eliminar/perfil', [UsuariosController::class, 'eliminarPefil']);

Route::post('post/listar', [PostsController::class, 'listarPost']);
Route::post('post/crear', [PostsController::class, 'crearPost']);
Route::post('post/editar', [PostsController::class, 'editarPost']);
