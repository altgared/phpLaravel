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
        Schema::table('users', function (Blueprint $table) {
            // Primero eliminamos la columna name que viene por defecto
            $table->dropColumn('name');
            
            // Agregamos las columnas requeridas
            $table->string('nombre')->after('id');
            $table->string('primer_apellido')->after('nombre');
            $table->string('segundo_apellido')->nullable()->after('primer_apellido');
            
            // Agregamos la relación con roles
            $table->foreignId('id_rol')->after('password')->constrained('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->dropColumn(['nombre', 'primer_apellido', 'segundo_apellido', 'id_rol']);
        });
    }
};