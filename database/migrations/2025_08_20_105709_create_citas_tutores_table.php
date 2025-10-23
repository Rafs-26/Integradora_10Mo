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
        Schema::create('citas_tutores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutor_id')->comment('ID del tutor (tabla profesores)');
            $table->unsignedBigInteger('estudiante_id')->comment('ID del estudiante (tabla estudiantes)');
            $table->unsignedBigInteger('estadia_id')->nullable()->comment('ID de la estadía relacionada');
            $table->string('titulo', 200)->comment('Título de la cita');
            $table->text('descripcion')->nullable()->comment('Descripción de la cita');
            $table->date('fecha')->comment('Fecha de la cita');
            $table->time('hora_inicio')->comment('Hora de inicio');
            $table->time('hora_fin')->comment('Hora de finalización');
            $table->enum('modalidad', ['presencial', 'virtual', 'telefonica'])->default('presencial')->comment('Modalidad de la cita');
            $table->string('ubicacion', 200)->nullable()->comment('Ubicación de la cita');
            $table->string('enlace_virtual', 500)->nullable()->comment('Enlace para cita virtual');
            $table->enum('status', ['programada', 'confirmada', 'completada', 'cancelada', 'reprogramada'])->default('programada')->comment('Estado de la cita');
            $table->text('observaciones_tutor')->nullable()->comment('Observaciones del tutor');
            $table->text('observaciones_estudiante')->nullable()->comment('Observaciones del estudiante');
            $table->timestamp('fecha_confirmacion')->nullable()->comment('Fecha de confirmación');
            $table->timestamp('fecha_cancelacion')->nullable()->comment('Fecha de cancelación');
            $table->text('motivo_cancelacion')->nullable()->comment('Motivo de cancelación');
            $table->unsignedBigInteger('creado_por')->comment('Usuario que creó la cita');
            $table->json('recordatorios')->nullable()->comment('Configuración de recordatorios');
            $table->timestamps();
            
            $table->foreign('tutor_id')->references('id')->on('profesores')->onDelete('cascade');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->foreign('estadia_id')->references('id')->on('estadias')->onDelete('set null');
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('restrict');
            
            $table->index('tutor_id');
            $table->index('estudiante_id');
            $table->index('fecha');
            $table->index('status');
            $table->index('modalidad');
            $table->index(['fecha', 'hora_inicio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas_tutores');
    }
};
