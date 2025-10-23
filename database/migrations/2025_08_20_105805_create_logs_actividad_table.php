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
        Schema::create('logs_actividad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id')->nullable()->comment('ID del usuario que realizó la acción');
            $table->string('accion', 100)->comment('Tipo de acción realizada');
            $table->string('tabla_afectada', 100)->nullable()->comment('Tabla de la base de datos afectada');
            $table->unsignedBigInteger('registro_id')->nullable()->comment('ID del registro afectado');
            $table->json('datos_anteriores')->nullable()->comment('Datos antes del cambio (JSON)');
            $table->json('datos_nuevos')->nullable()->comment('Datos después del cambio (JSON)');
            $table->text('descripcion')->nullable()->comment('Descripción detallada de la acción');
            $table->string('ip_address', 45)->nullable()->comment('Dirección IP del usuario');
            $table->string('user_agent', 500)->nullable()->comment('User Agent del navegador');
            $table->string('modulo', 100)->nullable()->comment('Módulo del sistema donde se realizó la acción');
            $table->enum('nivel', ['info', 'warning', 'error', 'critical'])->default('info')->comment('Nivel de importancia del log');
            $table->string('session_id', 100)->nullable()->comment('ID de la sesión');
            $table->json('contexto_adicional')->nullable()->comment('Información adicional de contexto');
            $table->timestamps();
            
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
            
            $table->index('usuario_id');
            $table->index('accion');
            $table->index('tabla_afectada');
            $table->index('registro_id');
            $table->index('nivel');
            $table->index('modulo');
            $table->index('created_at');
            $table->index(['usuario_id', 'created_at']);
            $table->index(['tabla_afectada', 'registro_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_actividad');
    }
};
