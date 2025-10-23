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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id')->comment('ID del usuario destinatario');
            $table->string('titulo', 200)->comment('Título de la notificación');
            $table->text('mensaje')->comment('Mensaje de la notificación');
            $table->enum('tipo', [
                'info', 'warning', 'error', 'success', 'cita', 'documento', 
                'estadia', 'sistema', 'recordatorio'
            ])->default('info')->comment('Tipo de notificación');
            $table->enum('prioridad', ['baja', 'media', 'alta', 'urgente'])->default('media')->comment('Prioridad de la notificación');
            $table->boolean('leida')->default(false)->comment('Indica si la notificación ha sido leída');
            $table->timestamp('fecha_leida')->nullable()->comment('Fecha en que se leyó la notificación');
            $table->string('enlace', 500)->nullable()->comment('Enlace relacionado con la notificación');
            $table->json('datos_adicionales')->nullable()->comment('Datos adicionales en formato JSON');
            $table->unsignedBigInteger('enviado_por')->nullable()->comment('Usuario que envió la notificación');
            $table->timestamp('fecha_expiracion')->nullable()->comment('Fecha de expiración de la notificación');
            $table->boolean('activa')->default(true)->comment('Indica si la notificación está activa');
            $table->timestamps();
            
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('enviado_por')->references('id')->on('users')->onDelete('set null');
            
            $table->index('usuario_id');
            $table->index('tipo');
            $table->index('prioridad');
            $table->index('leida');
            $table->index('activa');
            $table->index('created_at');
            $table->index(['usuario_id', 'leida']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
