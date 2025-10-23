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
        Schema::create('estadias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id')->comment('ID del estudiante (tabla estudiantes)');
            $table->unsignedBigInteger('tutor_id')->comment('ID del tutor asignado (tabla profesores)');
            $table->unsignedBigInteger('empresa_id')->comment('ID de la empresa');
            $table->string('periodo', 20)->comment('Período académico (ej: 2024-1)');
            $table->timestamp('fecha_solicitud')->useCurrent()->comment('Fecha de solicitud');
            $table->date('fecha_inicio')->nullable()->comment('Fecha de inicio de estadía');
            $table->date('fecha_fin')->nullable()->comment('Fecha de finalización');
            $table->enum('status', [
                'solicitud', 'carta_generada', 'carta_aceptada', 'en_proceso',
                'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca',
                'finalizada', 'cancelada'
            ])->default('solicitud')->comment('Estado actual de la estadía');
            $table->string('proyecto', 200)->nullable()->comment('Nombre del proyecto');
            $table->string('area_empresa', 100)->nullable()->comment('Área de la empresa donde realizará la estadía');
            $table->enum('modalidad', ['presencial', 'remota', 'hibrida'])->default('presencial')->comment('Modalidad de la estadía');
            $table->tinyInteger('horas_semanales')->unsigned()->nullable()->comment('Horas semanales de estadía');
            $table->text('observaciones')->nullable()->comment('Observaciones generales');
            $table->text('observaciones_tutor')->nullable()->comment('Observaciones del tutor');
            $table->text('observaciones_biblioteca')->nullable()->comment('Observaciones de biblioteca');
            $table->timestamps();
            
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->foreign('tutor_id')->references('id')->on('profesores')->onDelete('restrict');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('restrict');
            
            $table->index('estudiante_id');
            $table->index('tutor_id');
            $table->index('empresa_id');
            $table->index('periodo');
            $table->index('status');
            $table->index(['fecha_inicio', 'fecha_fin']);
            
            $table->unique(['estudiante_id', 'periodo'], 'unique_estudiante_periodo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estadias');
    }
};
