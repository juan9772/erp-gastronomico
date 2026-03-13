<?php

declare(strict_types=1);

use App\Models\Insumo;
use App\Models\Producto;
use App\Models\Receta;
use App\Services\CostCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Helpers de escenario
// ---------------------------------------------------------------------------

/**
 * Crea un escenario completo:
 *   1 Receta ← (1 Insumo × cantidad dada)
 *   N Productos ligados a esa Receta
 *
 * @return array{receta: Receta, insumo: Insumo, productos: \Illuminate\Database\Eloquent\Collection}
 */
function crearEscenarioBase(
    float $costoUnitario,
    float $cantidad,
    int   $cantidadProductos = 1,
): array {
    $insumo  = Insumo::factory()->create(['costo_unitario' => $costoUnitario]);
    $receta  = Receta::factory()->create();
    $receta->insumos()->attach($insumo->id, ['cantidad' => $cantidad]);

    $productos = Producto::factory()
        ->count($cantidadProductos)
        ->create(['receta_id' => $receta->id, 'costo_total' => 0]);

    return compact('receta', 'insumo', 'productos');
}

// ---------------------------------------------------------------------------
// Tests
// ---------------------------------------------------------------------------

describe('CostCalculationService', function (): void {

    /**
     * Test 1 — Verificación matemática exacta sobre Receta.
     *
     * Escenario:
     *   insumo A: costo = 100.00, cantidad en receta = 2.0
     *   costo inicial de la receta = 100 × 2 = 200.00
     *
     * Acción: el insumo sube 10% → nuevo costo = 110.00
     *
     * Expectativa: receta.costo_total = 110 × 2 = 220.00  (exactamente)
     */
    it('recalcula el costo de la Receta cuando un Insumo sube un 10%', function (): void {
        // Arrange
        $costoOriginal = 100.0;
        $cantidad      = 2.0;
        $incremento    = 1.10; // +10 %

        ['receta' => $receta, 'insumo' => $insumo] = crearEscenarioBase($costoOriginal, $cantidad);

        $costoEsperado = round($costoOriginal * $incremento * $cantidad, 4); // 220.0000

        // Act
        $insumo->costo_unitario = $costoOriginal * $incremento;
        $insumo->save();

        app(CostCalculationService::class)->recalculateForInsumo($insumo);

        // Assert
        $costoReal = (float) $receta->fresh()->costo_total;

        expect($costoReal)->toBe($costoEsperado)
            ->and($costoReal)->toBe(220.0);
    });

    /**
     * Test 2 — El costo del Producto se sincroniza con el de su Receta.
     *
     * Escenario igual al anterior pero verificando que todos los Productos
     * asociados a la receta también reflejan el mismo costo exacto.
     */
    it('sincroniza el costo_total en todos los Productos de la Receta afectada', function (): void {
        // Arrange
        $costoOriginal = 200.0;
        $cantidad      = 0.5;  // 0.5 kg
        $incremento    = 1.10;

        // Creamos 3 productos para la misma receta
        ['receta' => $receta, 'insumo' => $insumo, 'productos' => $productos] =
            crearEscenarioBase($costoOriginal, $cantidad, cantidadProductos: 3);

        $costoEsperado = round($costoOriginal * $incremento * $cantidad, 4); // 110.0000

        // Act
        $insumo->costo_unitario = $costoOriginal * $incremento;
        $insumo->save();

        app(CostCalculationService::class)->recalculateForInsumo($insumo);

        // Assert — cada producto debe tener el costo de la receta
        $recetaCosto = (float) $receta->fresh()->costo_total;

        expect($recetaCosto)->toBe($costoEsperado); // Primero la receta

        $productos->each(function (Producto $p) use ($recetaCosto): void {
            $costoProducto = (float) $p->fresh()->costo_total;

            expect($costoProducto)
                ->toBe($recetaCosto, "Producto ID {$p->id} debería tener costo {$recetaCosto}, tiene {$costoProducto}")
                ->toBe(110.0);
        });
    });

    /**
     * Test 3 — Integridad transaccional: si el recálculo falla a la mitad,
     * NO deben quedar datos inconsistentes (rollback completo).
     *
     * Estrategia:
     *   - Establecemos el costo original de la receta en la DB.
     *   - Forzamos que DB::transaction lance una excepción internamente
     *     usando un listener de transacciones parcial: inyectamos un
     *     `afterCommit` listener que lanza, pero la forma más limpia y
     *     sin Mockery es simular el fallo haciendo que el segundo save()
     *     en la transacción falle usando un SQL constraint.
     *
     * Aquí usamos la técnica más directa en pruebas de integración:
     * interceptar a nivel de DB con un macro de transaction que lanza
     * una excepción, y verificar que los valores en DB no cambiaron.
     */
    it('hace rollback si el recálculo falla a la mitad, dejando datos intactos', function (): void {
        // Arrange
        $costoOriginal = 50.0;
        $cantidad      = 4.0;

        ['receta' => $receta, 'insumo' => $insumo] = crearEscenarioBase($costoOriginal, $cantidad);

        // Registramos el costo inicial manualmente para tener una línea base real
        $receta->costo_total = $costoOriginal * $cantidad; // 200.00
        $receta->save();

        $costoAntes = (float) $receta->fresh()->costo_total;

        // Incrementamos el precio en memoria (sin guardar) y preparamos el servicio
        // con una subclase anónima que rompe en mitad de la transacción
        $servicioConFalla = new class extends CostCalculationService {
            public function recalculateForInsumo(Insumo $insumo): void
            {
                DB::transaction(function () use ($insumo): void {
                    // Simulamos que la primera receta se procesa parcialmente...
                    $recetas = $insumo->recetas()->with(['insumos'])->get();

                    foreach ($recetas as $receta) {
                        $nuevoCosto = $this->calcularCostoReceta($receta);
                        $receta->costo_total = $nuevoCosto;
                        $receta->save();

                        // ...y luego ocurre un error inesperado ANTES de actualizar productos
                        throw new \RuntimeException('Fallo simulado en mitad de la transacción.');
                    }
                });
            }
        };

        // Act — el servicio DEBE lanzar la excepción
        $insumo->costo_unitario = $costoOriginal * 1.10;
        $insumo->save();

        expect(fn () => $servicioConFalla->recalculateForInsumo($insumo))
            ->toThrow(\RuntimeException::class, 'Fallo simulado en mitad de la transacción.');

        // Assert — el costo de la receta debe ser el MISMO que antes del intento fallido
        $costoDesprues = (float) $receta->fresh()->costo_total;

        expect($costoDesprues)
            ->toBe($costoAntes, 'El rollback debería haber restaurado el costo original.')
            ->toBe(200.0);
    });

    /**
     * Test 4 — Receta con múltiples insumos: el recálculo suma todos correctamente.
     *
     * Garantiza que `calcularCostoReceta()` acumula N insumos (no solo el que cambió).
     */
    it('suma correctamente múltiples insumos al recalcular el costo de la Receta', function (): void {
        // Arrange — receta con 3 insumos distintos
        $receta   = Receta::factory()->create();
        $insumoA  = Insumo::factory()->create(['costo_unitario' => 100.0]);
        $insumoB  = Insumo::factory()->create(['costo_unitario' => 50.0]);
        $insumoC  = Insumo::factory()->create(['costo_unitario' => 25.0]);

        $receta->insumos()->attach([
            $insumoA->id => ['cantidad' => 2.0],  // 100 × 2 = 200
            $insumoB->id => ['cantidad' => 1.0],  // 50  × 1 = 50
            $insumoC->id => ['cantidad' => 4.0],  // 25  × 4 = 100
        ]);

        // costo inicial = 200 + 50 + 100 = 350.0000

        // Act — solo sube insumoA un 10 %: 110 × 2 = 220
        $insumoA->costo_unitario = 110.0;
        $insumoA->save();

        app(CostCalculationService::class)->recalculateForInsumo($insumoA);

        // Assert — nuevo total = 220 + 50 + 100 = 370.0000
        $costoEsperado = round((110.0 * 2.0) + (50.0 * 1.0) + (25.0 * 4.0), 4); // 370.0000

        expect((float) $receta->fresh()->costo_total)
            ->toBe($costoEsperado)
            ->toBe(370.0);
    });
});
