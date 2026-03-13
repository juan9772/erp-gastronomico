<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Representa un insumo (materia prima) con su costo unitario.
 *
 * @property int    $id
 * @property string $nombre
 * @property string $unidad_medida
 * @property float  $costo_unitario
 */
final class Insumo extends Model
{
    /** @use HasFactory<\Database\Factories\InsumoFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'unidad_medida',
        'costo_unitario',
    ];

    protected $casts = [
        'costo_unitario' => 'decimal:4',
    ];

    /**
     * Recetas que utilizan este insumo.
     * El pivot incluye la `cantidad` usada en cada receta.
     */
    public function recetas(): BelongsToMany
    {
        return $this->belongsToMany(Receta::class, 'receta_insumo')
            ->withPivot('cantidad');
    }
}
