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
        Schema::create('tipo_compras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
        DB::table('tipo_compras')->insert([
            ['nombre' => 'directa', 'disponible' => true],
            ['nombre' => 'licitación', 'disponible' => true],
            ['nombre' => 'consolidada', 'disponible' => true],
            ['nombre' => 'donación', 'disponible' => true],
            ['nombre' => 'promoción', 'disponible' => true],
            ['nombre' => 'otra', 'disponible' => true],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_compras');
    }
};
