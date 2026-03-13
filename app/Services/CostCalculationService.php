<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Insumo;
use App\Models\Receta;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Servicio de Cálculo de Costos en Cascada.
 *
 * Responsabilidad única: cuando el precio de un Insumo cambia,
 * recalcula el `costo_total` de todas las Recetas que lo usan
 * y sincroniza ese valor en los Productos derivados de cada receta.
 *
 * Todo el proceso ocurre dentro de una transacción de base de datos.
 * Si cualquier paso falla, se hace ROLLBACK completo para garantizar
 * consistencia de datos (sin registros huérfanos ni costos parciales).
 */
class CostCalculationService
{
    /**
     * Recalcula en cascada: Insumo → Recetas → Productos.
     *
     * @param  Insumo  $insumo  El insumo cuyo `costo_unitario` ya fue actualizado en memoria o en DB.
     * @throws Throwable        Si la transacción falla y hace rollback.
     */
    public function recalculateForInsumo(Insumo $insumo): void
    {
        DB::transaction(function () use ($insumo): void {
            // Carga todas las recetas que usan este insumo.
            // Eager-load TODOS sus insumos con su cantidad (pivot) para el recálculo.
            $recetas = $insumo->recetas()->with(['insumos'])->get();

            foreach ($recetas as $receta) {
                $nuevoCosto = $this->calcularCostoReceta($receta);

                $receta->costo_total = $nuevoCosto;
                $receta->save();

                // Sincroniza el costo a todos los productos de esta receta
                // en una sola consulta UPDATE para eficiencia.
                $receta->productos()->update(['costo_total' => $nuevoCosto]);
            }
        });
    }

    /**
     * Calcula el costo total de una receta sumando
     * (costo_unitario de cada insumo × cantidad del pivot).
     *
     * @param  Receta  $receta  Debe tener la relación `insumos` ya cargada (eager-loaded).
     */
    public function calcularCostoReceta(Receta $receta): float
    {
        return (float) $receta->insumos
            ->sum(fn (Insumo $insumo): float =>
                (float) $insumo->costo_unitario * (float) $insumo->pivot->cantidad
            );
    }
}
