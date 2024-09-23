<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaTareaTable extends Migration
{
    public function up()
    {
        Schema::create('lista_tarea', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lista_id')->constrained('listas')->onDelete('cascade');
            $table->foreignId('tarea_id')->constrained('tarea')->onDelete('cascade');
            $table->tinyInteger('estado')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lista_tarea');
    }
}
