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
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->comment('Nombre completo de la carrera');
            $table->string('codigo', 10)->unique()->comment('Código único de la carrera');
            $table->text('descripcion')->nullable()->comment('Descripción detallada de la carrera');
            $table->unsignedBigInteger('director_id')->nullable()->comment('ID del director asignado');
            $table->boolean('activa')->default(true)->comment('Estado de la carrera');
            $table->timestamps();
            
            $table->index('codigo');
            $table->index('director_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carreras');
    }
};
