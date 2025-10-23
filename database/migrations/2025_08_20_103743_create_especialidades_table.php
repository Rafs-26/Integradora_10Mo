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
        Schema::create('especialidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->comment('Nombre de la especialidad');
            $table->string('codigo', 10)->comment('Código de la especialidad');
            $table->unsignedBigInteger('carrera_id')->comment('Carrera a la que pertenece');
            $table->text('descripcion')->nullable()->comment('Descripción de la especialidad');
            $table->boolean('activa')->default(true)->comment('Estado de la especialidad');
            $table->timestamps();
            
            $table->foreign('carrera_id')->references('id')->on('carreras')->onDelete('cascade');
            $table->unique(['codigo', 'carrera_id'], 'unique_codigo_carrera');
            $table->index('carrera_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especialidades');
    }
};
