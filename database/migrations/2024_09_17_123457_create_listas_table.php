<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListasTable extends Migration
{
    public function up()
    {
        Schema::create('listas', function (Blueprint $table) {
            $table->id();
            $table->string('nombrelista');
            $table->text('descripcionlista')->nullable();
            $table->tinyInteger('estado')->default(0); 
            $table->timestamp('fechaDelete')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('listas');
    }
}
