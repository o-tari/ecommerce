<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class AttributeValue
 *
 * Represents a value belonging to a product attribute.
 *
 * @property int $id
 * @property int $attribute_id
 * @property string $attribute_value
 * @property string|null $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Attribute $attribute
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductAttribute[] $productAttributes
 */
class AttributeValue extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attribute_id',
        'attribute_value',
        'color',
    ];

    /**
     * Get the attribute that owns this value.
     *
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * The product attributes that have this attribute value.
     *
     * @return BelongsToMany
     */
    public function productAttributes(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductAttribute::class,
            'product_attribute_values',
            'attribute_value_id',
            'product_id'
        );
    }
}
