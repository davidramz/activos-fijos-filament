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

            $table->foreignId('tipo_id')->constrained('movimiento_tipos');

            $table->foreignId('empleado_origen_id')
                ->nullable()
                ->constrained('empleados');

            $table->foreignId('empleado_destino_id')
                ->nullable()
                ->constrained('empleados');

            $table->foreignId('status_antes_id')
                ->nullable()
                ->constrained('activo_status');
            $table->foreignId('status_despues_id')
                ->nullable()
                ->constrained('activo_status');

            $table->text('notas')->nullable();

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
