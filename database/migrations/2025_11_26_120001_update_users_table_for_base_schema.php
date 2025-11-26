<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'matricula')) {
                $table->string('matricula', 20)->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'nombre_completo')) {
                $table->string('nombre_completo', 200)->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['activo', 'inactivo', 'suspendido'])->default('activo')->after('password');
            }
            if (!Schema::hasColumn('users', 'acceso_anticipado')) {
                $table->boolean('acceso_anticipado')->default(false)->after('status');
            }
            if (!Schema::hasColumn('users', 'device_token')) {
                $table->string('device_token', 255)->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'ultimo_acceso')) {
                $table->timestamp('ultimo_acceso')->nullable()->after('device_token');
            }
            if (Schema::hasColumn('users', 'rol_id')) {
                $table->unsignedBigInteger('rol_id')->nullable()->change();
            } else {
                $table->unsignedBigInteger('rol_id')->nullable()->after('ultimo_acceso');
                $table->foreign('rol_id')->references('id')->on('roles')->onDelete('restrict');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'ultimo_acceso')) $table->dropColumn('ultimo_acceso');
            if (Schema::hasColumn('users', 'device_token')) $table->dropColumn('device_token');
            if (Schema::hasColumn('users', 'acceso_anticipado')) $table->dropColumn('acceso_anticipado');
            if (Schema::hasColumn('users', 'status')) $table->dropColumn('status');
            if (Schema::hasColumn('users', 'nombre_completo')) $table->dropColumn('nombre_completo');
            if (Schema::hasColumn('users', 'matricula')) $table->dropColumn('matricula');
        });
    }
};

