<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('historialempleados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->string('accion'); // Por ejemplo: inicio de sesión, cierre de sesión, proceso realizado, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historialempleados');
    }
};