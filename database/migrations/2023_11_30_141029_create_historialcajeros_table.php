<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historialcajeros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cajero_id');
            $table->foreign('cajero_id')->references('id')->on('cajeros')->onDelete('cascade');
            $table->string('accion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historialcajeros');
    }
};
