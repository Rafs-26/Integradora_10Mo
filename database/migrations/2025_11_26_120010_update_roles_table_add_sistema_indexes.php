<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            if (!Schema::hasColumn('roles', 'sistema')) {
                $table->boolean('sistema')->default(false)->after('activo');
            }
            $table->index('slug');
            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'sistema')) $table->dropColumn('sistema');
            $table->dropIndex(['slug']);
            $table->dropIndex(['activo']);
        });
    }
};

