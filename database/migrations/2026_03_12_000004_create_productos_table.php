<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table): void {
            $table->id();
            $table->string('nombre', 150);
            $table->foreignId('receta_id')
                ->nullable()
                ->constrained('recetas')
                ->nullOnDelete();
            $table->decimal('precio_venta', 12, 4)->unsigned()->default(0);
            // Mirror del costo de su receta — mantenido por CostCalculationService
            $table->decimal('costo_total', 12, 4)->unsigned()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
