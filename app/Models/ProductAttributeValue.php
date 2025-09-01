<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductAttributeValue
 *
 * Represents the relation between a product attribute and its attribute value.
 *
 * @package App\Models
 *
 * @property int $product_id
 * @property int $attribute_id
 * @property int $attribute_value_id
 *
 * @property Product $product
 * @property Attribute $attribute
 * @property AttributeValue $attributeValue
 */
class ProductAttributeValue extends Model
{
    use HasFactory;

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
        'product_id',
        'attribute_id',
        'attribute_value_id',
    ];

    protected $primaryKey = ['product_id', 'attribute_id', 'attribute_value_id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Get the product associated with this value.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the attribute associated with this value.
     *
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
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
