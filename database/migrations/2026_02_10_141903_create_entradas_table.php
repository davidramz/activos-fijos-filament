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
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->foreignId('user_id')->constrained();

            $table->string('folio')->unique();
            $table->string('requisicion');
            $table->enum('tipo_compra', [
                'directa', 'licitación', 'consolidada',
                'donación', 'promoción', 'otra'
            ]);

            $table->date('fecha_factura');

            $table->timestamps();

            $table->index('fecha_factura');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};
