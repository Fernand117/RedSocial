<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StateServerController extends Controller
{
    public $notFound = 404;
    public $resOK = 200;
    public $errServ = 500;

    public function mensaje($mensaje, $tipo){
        if($tipo == $this->resOK) {
            return response()->json(['Mensaje' => $mensaje]);
        } else if ($tipo == $this->notFound) {
            return response()->json(['Mensaje' => $mensaje], $this->notFound);
        } else if ($tipo == $this->errServ) {
            return response()->json(['Mensaje' => $mensaje], $this->errServ);
        }
    }
}
