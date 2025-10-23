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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estadia_id')->comment('ID de la estadía');
            $table->enum('tipo_documento', [
                'carta_presentacion', 'carta_aceptacion', 'cronograma_actividades',
                'carta_terminacion', 'evaluacion_empresa', 'evaluacion_tutor', 'memoria_estadia'
            ])->comment('Tipo de documento');
            $table->string('nombre_archivo', 255)->comment('Nombre original del archivo');
            $table->string('ruta_archivo', 500)->nullable()->comment('Ruta del archivo en el sistema');
            $table->longText('contenido_archivo')->nullable()->comment('Contenido del archivo en base64');
            $table->string('tipo_mime', 100)->comment('Tipo MIME del archivo');
            $table->unsignedInteger('tamaño_archivo')->comment('Tamaño del archivo en bytes');
            $table->string('hash_archivo', 64)->comment('Hash SHA-256 del archivo');
            $table->tinyInteger('version')->unsigned()->default(1)->comment('Versión del documento');
            $table->enum('status', ['pendiente', 'validado', 'rechazado', 'revision'])->default('pendiente')->comment('Estado del documento');
            $table->timestamp('fecha_subida')->useCurrent()->comment('Fecha de subida');
            $table->unsignedBigInteger('subido_por')->comment('Usuario que subió el documento');
            $table->timestamp('fecha_validacion')->nullable()->comment('Fecha de validación');
            $table->unsignedBigInteger('validado_por')->nullable()->comment('Usuario que validó el documento');
            $table->text('observaciones')->nullable()->comment('Observaciones sobre el documento');
            $table->unsignedBigInteger('documento_anterior_id')->nullable()->comment('ID del documento anterior (para versiones)');
            $table->json('metadata')->nullable()->comment('Información adicional en formato JSON');
            $table->timestamps();
            
            $table->foreign('estadia_id')->references('id')->on('estadias')->onDelete('cascade');
            $table->foreign('subido_por')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('validado_por')->references('id')->on('users')->onDelete('set null');
            $table->foreign('documento_anterior_id')->references('id')->on('documentos')->onDelete('set null');
            
            $table->index('estadia_id');
            $table->index('tipo_documento');
            $table->index('status');
            $table->index('subido_por');
            $table->index('validado_por');
            $table->index('fecha_subida');
            $table->index('hash_archivo');
            
            $table->unique('hash_archivo');
            $table->unique(['estadia_id', 'tipo_documento', 'version'], 'unique_estadia_tipo_version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
