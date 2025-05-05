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
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_expediente')->unique();
            $table->text('asunto');
            $table->date('fecha_inicio');
            $table->foreignId('id_estatus')->constrained('estatus');
            $table->foreignId('id_usuario_registra')->constrained('users');
            $table->timestamps();
            $table->softDeletes(); // Para el borrado lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};