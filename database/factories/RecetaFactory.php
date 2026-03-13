<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Receta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Receta>
 */
final class RecetaFactory extends Factory
{
    protected $model = Receta::class;

    public function definition(): array
    {
        return [
            'nombre'      => 'Receta ' . $this->faker->unique()->lexify('?????'),
            'costo_total' => 0.0, // Calculado por CostCalculationService
        ];
    }
}
