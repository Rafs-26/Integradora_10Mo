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
        Schema::table('solicitud_carta_presentacions', function (Blueprint $table) {
            // Modificar el enum de estado para incluir los nuevos valores
            $table->dropColumn('estado');
        });
        
        Schema::table('solicitud_carta_presentacions', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'aprobada_profesor', 'rechazada_profesor', 'aprobada_director', 'rechazada_director', 'generada', 'reemplazada'])->default('pendiente');
            
            // Campos para revisión del profesor
            $table->timestamp('fecha_revision_profesor')->nullable();
            $table->timestamp('fecha_aprobacion_profesor')->nullable();
            $table->boolean('revisada_por_profesor')->default(false);
            $table->text('comentarios_profesor')->nullable();
            
            // Campos para revisión del director
            $table->timestamp('fecha_revision_director')->nullable();
            $table->boolean('aprobada_por_director')->default(false);
            $table->text('comentarios_director')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud_carta_presentacions', function (Blueprint $table) {
            $table->dropColumn([
                'fecha_revision_profesor',
                'fecha_aprobacion_profesor',
                'revisada_por_profesor',
                'comentarios_profesor',
                'fecha_revision_director',
                'aprobada_por_director',
                'comentarios_director'
            ]);
            
            $table->dropColumn('estado');
        });
        
        Schema::table('solicitud_carta_presentacions', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
        });
    }
};
