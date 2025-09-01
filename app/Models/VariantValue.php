<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'variant_id',
        'product_attribute_value_id',
    ];

    protected $primaryKey = ['variant_id', 'product_attribute_value_id'];
    public $incrementing = false;
    public $timestamps = false;

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function productAttributeValue(): BelongsTo
    {
        return $this->belongsTo(ProductAttributeValue::class);
    }
}
