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
        Schema::create('asignaciones_tutor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutor_id')->comment('ID del tutor (tabla profesores)');
            $table->unsignedBigInteger('estudiante_id')->comment('ID del estudiante (tabla estudiantes)');
            $table->unsignedBigInteger('carrera_id')->comment('ID de la carrera');
            $table->unsignedBigInteger('director_id')->comment('Director que realizó la asignación (tabla profesores)');
            $table->string('periodo', 20)->comment('Período académico');
            $table->enum('status', ['activa', 'completada', 'cancelada', 'reasignada'])->default('activa')->comment('Estado de la asignación');
            $table->timestamp('fecha_asignacion')->useCurrent()->comment('Fecha de asignación');
            $table->timestamp('fecha_completada')->nullable()->comment('Fecha de completado');
            $table->text('motivo_cambio')->nullable()->comment('Motivo de cambio o cancelación');
            $table->timestamps();
            
            $table->foreign('tutor_id')->references('id')->on('profesores')->onDelete('cascade');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->foreign('carrera_id')->references('id')->on('carreras')->onDelete('restrict');
            $table->foreign('director_id')->references('id')->on('profesores')->onDelete('restrict');
            
            $table->index('tutor_id');
            $table->index('estudiante_id');
            $table->index('periodo');
            $table->index('status');
            
            $table->unique(['estudiante_id', 'periodo'], 'unique_estudiante_periodo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones_tutor');
    }
};
