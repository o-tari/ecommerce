<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $product_id
 * @property float $weight
 * @property string $weight_unit
 * @property float $volume
 * @property string $volume_unit
 * @property float $dimension_width
 * @property float $dimension_height
 * @property float $dimension_depth
 * @property string $dimension_unit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */

class ProductShippingInfo extends Model
{
    /** @use HasFactory<\Database\Factories\ProductShippingInfoFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'weight',
        'weight_unit',
        'volume',
        'volume_unit',
        'dimension_width',
        'dimension_height',
        'dimension_depth',
        'dimension_unit',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'weight' => 'decimal:2',
        'volume' => 'decimal:2',
        'dimension_width' => 'decimal:2',
        'dimension_height' => 'decimal:2',
        'dimension_depth' => 'decimal:2',
    ];

    /**
     * Get the product that owns the shipping information.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
