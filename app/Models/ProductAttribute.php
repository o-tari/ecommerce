<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ProductAttribute
 *
 * Represents the relationship between a product and an attribute.
 *
 * @property int $product_id
 * @property int $attribute_id
 *
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Attribute $attribute
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributeValue[] $attributeValues
 */
class ProductAttribute extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'attribute_id',
    ];

    protected $primaryKey = ['product_id', 'attribute_id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Get the product that owns this product attribute.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the attribute that this product attribute belongs to.
     *
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * The attribute values associated with this product attribute.
     *
     * @return BelongsToMany
     */
    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_attribute_values',
            'product_id',
            'attribute_value_id'
        )->wherePivot('attribute_id', $this->attribute_id);
    }
}
