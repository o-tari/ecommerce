<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductAttributeValue
 *
 * Represents the relation between a product attribute and its attribute value.
 *
 * @package App\Models
 *
 * @property int $product_attribute_id
 * @property int $attribute_value_id
 *
 * @property ProductAttribute $productAttribute
 * @property AttributeValue $attributeValue
 */
class ProductAttributeValue extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_attribute_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'product_attribute_id',
        'attribute_value_id',
    ];

    protected $primaryKey = ['product_attribute_id', 'attribute_value_id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Get the product attribute associated with this value.
     *
     * @return BelongsTo
     */
    public function productAttribute(): BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    /**
     * Get the attribute value associated with this product attribute.
     *
     * @return BelongsTo
     */
    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
