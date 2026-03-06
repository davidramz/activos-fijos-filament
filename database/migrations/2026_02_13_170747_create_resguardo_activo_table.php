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
        Schema::create('resguardo_activo', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resguardo_id')
                ->constrained('resguardos')
                ->cascadeOnDelete();

            $table->foreignId('activo_id')
                ->constrained('activos')
                ->cascadeOnDelete();

            // Evita que un mismo activo se repita en el mismo resguardo
            $table->unique(['resguardo_id', 'activo_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resguardo_activo');
    }
};
