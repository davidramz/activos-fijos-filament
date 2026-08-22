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
        Schema::create('baja_activo', function (Blueprint $table) {
            $table->id();

            $table->foreignId('baja_id')
                ->constrained('bajas')
                ->cascadeOnDelete();

            $table->foreignId('activo_id')
                ->constrained('activos')
                ->cascadeOnDelete();

            // Evita que un mismo activo se repita en el mismo resguardo
            $table->unique(['baja_id', 'activo_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baja_activo');
    }
};
