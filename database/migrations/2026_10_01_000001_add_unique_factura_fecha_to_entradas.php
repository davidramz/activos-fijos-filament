<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas', function (Blueprint $table): void {
            $table->dropUnique(['consecutivo']);
            $table->unique(['consecutivo', 'fecha_factura']);
        });
    }

    public function down(): void
    {
        Schema::table('entradas', function (Blueprint $table): void {
            $table->dropUnique(['consecutivo', 'fecha_factura']);
            $table->unique('consecutivo');
        });
    }
};