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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique()->comment('ID del usuario base');
            $table->unsignedBigInteger('carrera_id')->comment('ID de la carrera');
            $table->unsignedBigInteger('especialidad_id')->nullable()->comment('ID de la especialidad');
            $table->tinyInteger('cuatrimestre')->unsigned()->comment('Cuatrimestre actual');
            $table->string('telefono', 15)->nullable()->comment('Teléfono del estudiante');
            $table->date('fecha_nacimiento')->nullable()->comment('Fecha de nacimiento');
            $table->text('direccion')->nullable()->comment('Dirección completa');
            $table->string('ciudad', 100)->nullable()->comment('Ciudad de residencia');
            $table->string('estado', 100)->nullable()->comment('Estado de residencia');
            $table->string('codigo_postal', 10)->nullable()->comment('Código postal');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('carrera_id')->references('id')->on('carreras')->onDelete('restrict');
            $table->foreign('especialidad_id')->references('id')->on('especialidades')->onDelete('set null');
            
            $table->index('cuatrimestre');
            $table->index('carrera_id');
            $table->index('especialidad_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
