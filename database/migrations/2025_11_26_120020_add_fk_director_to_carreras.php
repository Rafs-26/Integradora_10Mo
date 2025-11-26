<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carreras', function (Blueprint $table) {
            if (Schema::hasColumn('carreras', 'director_id')) {
                $table->foreign('director_id')->references('id')->on('profesores')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->dropForeign(['director_id']);
        });
    }
};

