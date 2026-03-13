<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Insumo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Insumo>
 */
final class InsumoFactory extends Factory
{
    protected $model = Insumo::class;

    public function definition(): array
    {
        return [
            'nombre'         => rtrim($this->faker->sentence(3), '.'),
            'unidad_medida'  => $this->faker->randomElement(['kg', 'lt', 'un', 'gr']),
            'costo_unitario' => $this->faker->randomFloat(4, 0.5, 500),
        ];
    }
}
