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
        Schema::create('solicitud_carta_presentacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('estadia_id')->constrained('estadias')->onDelete('cascade');
            $table->string('dirigida_a');
            $table->string('cargo_destinatario')->nullable();
            $table->string('proposito');
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'generada'])->default('pendiente');
            $table->timestamp('fecha_solicitud');
            $table->timestamp('fecha_procesada')->nullable();
            $table->foreignId('procesada_por')->nullable()->constrained('users')->onDelete('set null');
            $table->text('comentarios_coordinador')->nullable();
            $table->string('archivo_carta')->nullable(); // Ruta del archivo PDF generado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_carta_presentacions');
    }
};
