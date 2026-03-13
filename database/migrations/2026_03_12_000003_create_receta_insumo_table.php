<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receta_insumo', function (Blueprint $table): void {
            $table->foreignId('receta_id')
                ->constrained('recetas')
                ->cascadeOnDelete();

            $table->foreignId('insumo_id')
                ->constrained('insumos')
                ->cascadeOnDelete();

            // Cantidad del insumo utilizada en la receta (ej: 0.250 kg)
            $table->decimal('cantidad', 10, 4)->unsigned()->default(0);

            $table->primary(['receta_id', 'insumo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receta_insumo');
    }
};
