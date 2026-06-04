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
        Schema::create('movimiento_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });

         DB::table('movimiento_tipos')->insert([
            ['nombre' => 'creado', 'disponible' => true],
            ['nombre' => 'asignado', 'disponible' => true],
            ['nombre' => 'transferido', 'disponible' => true],
            ['nombre' => 'devolucion', 'disponible' => true],
            ['nombre' => 'baja', 'disponible' => true],
        ]);
    }
   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_tipos');
    }
};
