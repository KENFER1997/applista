<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasTable extends Migration
{
    public function up()
    {
        Schema::create('tarea', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('detalle')->nullable();
            $table->unsignedBigInteger('lista_id')->unsigned('estado');
            $table->timestamps();
            $table->dateTime('fechaDelete')->nullable();
            $table->tinyInteger('estado')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tarea');
    }
}
