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
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variantOption(): BelongsTo
    {
        return $this->belongsTo(VariantOption::class);
    }

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductAttributeValue::class,
            'variant_values',
            'variant_id',
            'product_attribute_value_id'
        );
    }
}
