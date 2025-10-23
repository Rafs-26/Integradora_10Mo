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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social', 200)->comment('Razón social de la empresa');
            $table->string('nombre_comercial', 150)->nullable()->comment('Nombre comercial');
            $table->string('rfc', 13)->unique()->comment('RFC de la empresa');
            $table->text('direccion')->comment('Dirección completa');
            $table->string('ciudad', 100)->comment('Ciudad');
            $table->string('estado', 100)->comment('Estado');
            $table->string('codigo_postal', 10)->comment('Código postal');
            $table->string('telefono', 15)->comment('Teléfono principal');
            $table->string('email', 255)->comment('Email corporativo');
            $table->string('sitio_web', 255)->nullable()->comment('Sitio web de la empresa');
            $table->string('contacto_nombre', 100)->comment('Nombre del contacto');
            $table->string('contacto_puesto', 100)->comment('Puesto del contacto');
            $table->string('contacto_telefono', 15)->comment('Teléfono del contacto');
            $table->string('contacto_email', 255)->comment('Email del contacto');
            $table->string('sector', 100)->nullable()->comment('Sector económico');
            $table->string('giro', 150)->nullable()->comment('Giro de la empresa');
            $table->enum('tamaño', ['micro', 'pequeña', 'mediana', 'grande'])->nullable()->comment('Tamaño de la empresa');
            $table->enum('status', ['activa', 'inactiva', 'suspendida'])->default('activa')->comment('Estado de la empresa');
            $table->text('observaciones')->nullable()->comment('Observaciones adicionales');
            $table->timestamps();
            
            $table->index('rfc');
            $table->index('status');
            $table->index('ciudad');
            $table->index('estado');
            $table->index('sector');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
