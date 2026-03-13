<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Receta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
final class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            'nombre'       => 'Producto ' . $this->faker->unique()->lexify('?????'),
            'receta_id'    => Receta::factory(),
            'precio_venta' => $this->faker->randomFloat(4, 100, 5000),
            'costo_total'  => 0.0, // Calculado por CostCalculationService
        ];
    }
}
