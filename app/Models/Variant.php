<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'variant_option',
        'product_id',
        'variant_option_id',
        'sku',
        'price',
        'quantity',
        'weight',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variantOption(): BelongsTo
    {
        return $this->belongsTo(VariantOption::class);
    }

    public function variantOptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VariantOption::class);
    }

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'variant_values',
            'variant_id',
            'attribute_value_id'
        );
    }

    public function productAttributes(): BelongsToMany
    {
        return $this->belongsToMany(
            Attribute::class,
            'variant_values',
            'variant_id',
            'attribute_id'
        );
    }
}
