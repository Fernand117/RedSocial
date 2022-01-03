<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    public function validarUsuario($us)
    {
        $usuario = Usuario::where('usuario', '=', $us)->first();
        if ($usuario == null) {
            return false;
        } else {
            return true;
        }
    }

    public function validarEmail($mail)
    {
        $email = Usuario::where('email', '=', $mail)->first();
        if ($email == null) {
            return false;
        } else {
            return true;
        }
    }

    public function validarPerfil($idPerfil)
    {
        $perfil = DB::select('select * from perfiles where id = ?', [$idPerfil]);
        if ($perfil == null) {
            return false;
        } else {
            return true;
        }
    }

    public function registrarUsuario(Request $request)
    {
        $datos = $request->all();

        $state = new StateServerController();
        $usuario = new Usuario();
        $usControl = new UsuariosController();

        if ($usControl->validarUsuario($datos['usuario']) == true) {
            return $state->mensaje("Este nombre de usuario ya existe", 404);
        } else {
            $usuario->usuario = $datos['usuario'];
        }

        if ($usControl->validarEmail($datos['email']) == true) {
            return $state->mensaje("Este correo ya está registrado", 404);
        } else {
            $usuario->email = $datos['email'];
            $usuario->password = md5($datos['password']);
            $usuario->save();
        }

        if ($usControl->validarUsuario($datos['usuario']) == true) {
            return $state->mensaje("Usuario registrado correctamente", 200);
        } else {
            return $state->mensaje("Error al intentar registrar este usuario", 404);
        }
    }

    public function loginUsuario(Request $request)
    {
        $state = new StateServerController();

        $datos = $request->all();
        $usuario = DB::select('select * from usuarios where usuario = ? and password = ?', [$datos['usuario'], md5($datos['password'])]);

        if ($usuario == null) {
            return $state->mensaje('Usuario o contraseña incorrectos', 404);
        } else {
            return $state->mensaje($usuario, 200);
        }
    }

    public function crearPerfil(Request $request)
    {
        $state = new StateServerController();
        $usController = new UsuariosController();
        $datos = $request->all();
        $perfil = new Perfil();

        $perfil->nombre = $datos['nombre'];
        $perfil->paterno = $datos['paterno'];
        $perfil->materno = $datos['materno'];
        $perfil->edad = $datos['edad'];
        $perfil->fecha_nacimiento = $datos['fecha_nacimiento'];
        $perfil->idUsuario = $datos['idUsuario'];
        $perfil->save();

        if ($usController->validarPerfil($perfil->id) == true) {
            return $state->mensaje('Perfil de usuario creado correctamente', 200);
        } else {
            return $state->mensaje('Error, no se pudo crear su perfil', 404);
        }
    }

    public function editarPerfil(Request $request)
    {
        $datos = $request->all();

        $state = new StateServerController();

		$perfil = Perfil::find($datos['idPerfil']);

        if (isset($datos['nombre'])) {
            $perfil->nombre = $datos['nombre'];
        }

        if (isset($datos['paterno'])) {
            $perfil->paterno = $datos['paterno'];
        }

        if (isset($datos['materno'])) {
            $perfil->materno = $datos['materno'];
        }

        if (isset($datos['edad'])) {
            $perfil->edad = $datos['edad'];
        }

        if (isset($datos['fecha_nacimiento'])) {
            $perfil->fecha_nacimiento = $datos['fecha_nacimiento'];
        }

        $perfil->update();

        return $state->mensaje($perfil, 200);
    }

    public function eliminarPerfil(Request $request)
    {
        $state = new StateServerController();

        $datos = $request->all();
        $perfil = Perfil::find($datos['idPerfil']);
        $usuario = Usuario::find($datos['idUsuario']);
        $usuario->delete();
        $perfil->delete();

        return $state->mensaje('Cuenta eliminada correctamente', 200);
    }
}
