<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insumos', function (Blueprint $table): void {
            $table->id();
            $table->string('nombre', 150);
            $table->string('unidad_medida', 20)->comment('kg, lt, un, gr, etc.');
            // Alta precisión: 12 dígitos totales, 4 decimales (permite hasta 99.999.999,9999)
            $table->decimal('costo_unitario', 12, 4)->unsigned()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
