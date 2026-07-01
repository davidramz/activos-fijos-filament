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
        Schema::create('material_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });

        DB::table('material_tipos')->insert([
            ['nombre' => 'Activo Fijo', 'disponible' => true],
            ['nombre' => 'Consumible', 'disponible' => true],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_tipos');
    }
};
