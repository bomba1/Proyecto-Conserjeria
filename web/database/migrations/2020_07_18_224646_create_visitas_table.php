<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha', 0);
            $table->timestamps();

            // Claves foraneas
            $table->foreignId('persona_id');
            $table->foreignId('propiedad_id');

            $table->foreign('persona_id')->references('id')->on('personas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('propiedad_id')->references('id')->on('propiedades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitas');
    }
}
