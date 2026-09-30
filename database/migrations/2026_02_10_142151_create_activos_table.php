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
        Schema::create('activos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('material_id')->constrained('materiales');
            $table->foreignId('entrada_id')->constrained('entradas');

            $table->longText('detalles')->nullable();
            $table->json('imagenes')->nullable();
            $table->decimal('costo', 9, 2)->nullable();

            $table->string('numero_inventario',50)->unique();
            $table->string('numero_serie')->nullable();

            $table->date('garantia')->nullable();
            //Nunca cambiar status sin crear movimiento.
            $table->foreignId('status_id')
                ->constrained('activo_status')
                ->default(1); 
            // Asumiendo que '1' es el ID del estado "En Almacén"
            //empleado_actual_id Null = ALMACEN
            //Si no es null → status debe ser RESGUARDADO
            $table->foreignId('empleado_actual_id')
                ->nullable()
                ->constrained('empleados');
           
            $table->timestamps();     
            
            $table->index('status_id');
            $table->index('empleado_actual_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activos');
    }
};
