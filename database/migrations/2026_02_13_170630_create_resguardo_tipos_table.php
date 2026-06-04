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
        Schema::create('resguardo_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });

        DB::table('resguardo_tipos')->insert([
            ['nombre' => 'resguardo de activos', 'disponible' => true],
            ['nombre' => 'devolución por resguardo', 'disponible' => true],
            ['nombre' => 'resguardo entre empleados', 'disponible' => true],
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resguardo_tipos');
    }
};
