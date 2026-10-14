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
        Schema::create('activo_status', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
        
        // DB::table('activo_status')->insert([
        //     ['nombre' => 'almacen', 'disponible' => true],
        //     ['nombre' => 'resguardado', 'disponible' => true],
        //     ['nombre' => 'baja', 'disponible' => true],
        //     ['nombre' => 'Dev. proveedor', 'disponible' => true],
        //     ['nombre' => 'SUCEPTIBLE', 'disponible' => true],
        //     ['nombre' => 'CANCELADO', 'disponible' => true],
        //     ['nombre' => 'REPARACION', 'disponible' => true],
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activo_status');
    }
};
