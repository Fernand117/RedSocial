<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfiles', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->nullable(false);
            $table->string("paterno")->nullable(false);
            $table->string("materno")->nullable(false);
            $table->string("edad", 2)->nullable(false);
            $table->string("fecha_nacimiento")->nullable(false);
            $table->bigInteger("idUsuario")->unsigned();
            $table->foreign("idUsuario")->references("id")->on("usuarios");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfiles');
    }
}
