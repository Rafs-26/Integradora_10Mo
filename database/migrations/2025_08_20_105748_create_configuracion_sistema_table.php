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
        Schema::create('configuracion_sistema', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 100)->unique()->comment('Clave única de configuración');
            $table->string('nombre', 200)->comment('Nombre descriptivo de la configuración');
            $table->text('valor')->nullable()->comment('Valor de la configuración');
            $table->enum('tipo', ['string', 'integer', 'boolean', 'json', 'text', 'date', 'datetime'])->default('string')->comment('Tipo de dato del valor');
            $table->text('descripcion')->nullable()->comment('Descripción de la configuración');
            $table->string('categoria', 100)->default('general')->comment('Categoría de la configuración');
            $table->boolean('es_publica')->default(false)->comment('Indica si la configuración es pública');
            $table->boolean('es_editable')->default(true)->comment('Indica si la configuración es editable');
            $table->text('valor_por_defecto')->nullable()->comment('Valor por defecto');
            $table->text('opciones_validas')->nullable()->comment('Opciones válidas (JSON)');
            $table->unsignedBigInteger('modificado_por')->nullable()->comment('Usuario que modificó la configuración');
            $table->timestamp('fecha_modificacion')->nullable()->comment('Fecha de última modificación');
            $table->timestamps();
            
            $table->foreign('modificado_por')->references('id')->on('users')->onDelete('set null');
            
            $table->index('clave');
            $table->index('categoria');
            $table->index('es_publica');
            $table->index('es_editable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_sistema');
    }
};
