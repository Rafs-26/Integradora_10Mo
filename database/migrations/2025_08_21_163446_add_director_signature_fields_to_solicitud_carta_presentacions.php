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
            // Campos para firma digital del director
            $table->string('archivo_firmado')->nullable()->after('archivo_carta');
            $table->string('firma_director')->nullable()->after('archivo_firmado');
            $table->integer('progreso')->default(20)->after('firma_director'); // Porcentaje de progreso
            
            // Campos adicionales para la carta
            $table->string('empresa_nombre')->nullable()->after('progreso');
            $table->date('fecha_inicio')->nullable()->after('empresa_nombre');
            $table->date('fecha_fin')->nullable()->after('fecha_inicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud_carta_presentacions', function (Blueprint $table) {
            $table->dropColumn([
                'archivo_firmado',
                'firma_director',
                'progreso',
                'empresa_nombre',
                'fecha_inicio',
                'fecha_fin'
            ]);
        });
    }
};
