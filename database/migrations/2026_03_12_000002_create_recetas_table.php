<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table): void {
            $table->id();
            $table->string('nombre', 150);
            // Calculado y mantenido por CostCalculationService — NO se escribe directamente
            $table->decimal('costo_total', 12, 4)->unsigned()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
