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
        Schema::create('profesores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique()->comment('ID del usuario base');
            $table->string('numero_empleado', 20)->unique()->comment('Número de empleado');
            $table->string('departamento', 100)->comment('Departamento al que pertenece');
            $table->string('titulo_academico', 100)->nullable()->comment('Título académico más alto');
            $table->text('especialidades_docencia')->nullable()->comment('Especialidades de docencia');
            $table->boolean('activo_como_tutor')->default(true)->comment('Activo como tutor de estadías');
            $table->unsignedBigInteger('carrera_dirigida_id')->nullable()->comment('ID de carrera que dirige (si es director)');
            $table->string('telefono', 15)->nullable()->comment('Teléfono del profesor');
            $table->text('direccion')->nullable()->comment('Dirección completa');
            $table->string('ciudad', 100)->nullable()->comment('Ciudad de residencia');
            $table->string('estado', 100)->nullable()->comment('Estado de residencia');
            $table->string('codigo_postal', 10)->nullable()->comment('Código postal');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('carrera_dirigida_id')->references('id')->on('carreras')->onDelete('set null');
            
            $table->index('numero_empleado');
            $table->index('departamento');
            $table->index('carrera_dirigida_id');
            $table->index('activo_como_tutor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesores');
    }
};
