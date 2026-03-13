<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Producto terminado que se vende al cliente.
 * Su `costo_total` es un mirror del costo de su receta, mantenido
 * exclusivamente por {@see \App\Services\CostCalculationService}.
 *
 * @property int        $id
 * @property string     $nombre
 * @property int|null   $receta_id
 * @property float      $precio_venta
 * @property float      $costo_total
 */
final class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'receta_id',
        'precio_venta',
        'costo_total',
    ];

    protected $casts = [
        'precio_venta' => 'decimal:4',
        'costo_total'  => 'decimal:4',
    ];

    /**
     * Receta de la cual proviene el costo de este producto.
     */
    public function receta(): BelongsTo
    {
        return $this->belongsTo(Receta::class);
    }
}
