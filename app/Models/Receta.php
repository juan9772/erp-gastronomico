<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Receta gastronómica. Su `costo_total` es calculado y mantenido
 * exclusivamente por {@see \App\Services\CostCalculationService}.
 *
 * @property int    $id
 * @property string $nombre
 * @property float  $costo_total
 */
final class Receta extends Model
{
    /** @use HasFactory<\Database\Factories\RecetaFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'costo_total',
    ];

    protected $casts = [
        'costo_total' => 'decimal:4',
    ];

    /**
     * Insumos que componen esta receta junto con la cantidad usada.
     */
    public function insumos(): BelongsToMany
    {
        return $this->belongsToMany(Insumo::class, 'receta_insumo')
            ->withPivot('cantidad');
    }

    /**
     * Productos que se elaboran a partir de esta receta.
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }
}
