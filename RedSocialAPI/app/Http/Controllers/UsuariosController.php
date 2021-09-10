<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function validarUsuario($us) {
        $usuario = Usuario::where('usuario', '=', $us);
        if ($usuario != null) {
            return true;
        } else {
            return false;
        }
    }

    public function validarEmail($mail) {
        $email = Usuario::where('email', '=', $mail);
        if ($email != null) {
            return true;
        } else {
            return false;
        }
    }

    public function registrarUsuario(Request $request)
    {
        $datos = $request->all();

        $state = new StateServerController();
        $usuario = new Usuario();
        $usControl = new UsuariosController();

        if($usControl->validarUsuario($datos['usuario']) == true) {
            $state->mensaje("Este nombre de usuario ya existe", 404);
        } else {
            $usuario->usuario = $datos['usuario'];
        }

        if ($usControl->validarEmail($datos['email']) == true) {
            $state->mensaje("Este correo ya está registrado", 404);
        } else {
            $usuario->email = $datos['email'];
        }

        $usuario->password = $datos['password'];
        $usuario->save();

        if($usControl->validarUsuario($datos['usuario']) == true) {
            $state->mensaje("Usuario registrado correctamente", 200);
        }
    }
}
