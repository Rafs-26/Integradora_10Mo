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
        // Primero eliminar la columna estado
        Schema::table('solicitud_carta_presentacions', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
        
        // Luego recrear con el nuevo valor 'reemplazada'
        Schema::table('solicitud_carta_presentacions', function (Blueprint $table) {
            $table->enum('estado', [
                'pendiente',           // Solicitud inicial
                'aprobada_profesor',   // Aprobada por profesor
                'rechazada_profesor',  // Rechazada por profesor
                'aprobada_director',   // Aprobada por director
                'rechazada_director',  // Rechazada por director
                'generada',           // Carta generada
                'reemplazada'         // Solicitud reemplazada por una nueva
            ])->default('pendiente')->after('observaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la columna estado
        Schema::table('solicitud_carta_presentacions', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
        
        // Recrear sin el valor 'reemplazada'
        Schema::table('solicitud_carta_presentacions', function (Blueprint $table) {
            $table->enum('estado', [
                'pendiente',           // Solicitud inicial
                'aprobada_profesor',   // Aprobada por profesor
                'rechazada_profesor',  // Rechazada por profesor
                'aprobada_director',   // Aprobada por director
                'rechazada_director',  // Rechazada por director
                'generada'            // Carta generada
            ])->default('pendiente')->after('observaciones');
        });
    }
};
