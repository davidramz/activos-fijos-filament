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
        Schema::create('activo_movimientos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activo_id')->constrained('activos');
            // user_id
            // Te dice quién ejecutó la acción
            // No confundir con responsable del bien
            $table->foreignId('user_id')->constrained();

            $table->enum('tipo', [
                'CREATE',
                'ASSIGN',
                'TRANSFER',
                'RETURN',
                'ADJUST',
                'BAJA'
            ]);

            $table->foreignId('empleado_from_id')
                ->nullable()
                ->constrained('empleados');

            $table->foreignId('empleado_to_id')
                ->nullable()
                ->constrained('empleados');

            $table->enum('status_before', [
                'ALMACEN',
                'RESGUARDADO',
                'BAJA',
                'EXTRAVIADO',
                'DANADO'
            ])->nullable();

            $table->enum('status_after', [
                'ALMACEN',
                'RESGUARDADO',
                'BAJA',
                'EXTRAVIADO',
                'DANADO'
            ])->nullable();

            $table->text('notes')->nullable();
            
            $table->index('activo_id');
            $table->index('created_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activo_movimientos');
    }
};
