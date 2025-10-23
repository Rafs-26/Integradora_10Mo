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
            $table->unsignedBigInteger('revisada_por_director')->nullable()->after('aprobada_por_director');
            $table->foreign('revisada_por_director')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud_carta_presentacions', function (Blueprint $table) {
            $table->dropForeign(['revisada_por_director']);
            $table->dropColumn('revisada_por_director');
        });
    }
};
