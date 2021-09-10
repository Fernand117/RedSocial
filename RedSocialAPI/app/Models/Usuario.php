<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = "usuarios";
    protected $fillabel = [
        'usuario', 'email', 'password', 'nombre', 'paterno', 'materno', 'edad', 'fecha_nacimiento', 'idUsuario'
    ];
}
