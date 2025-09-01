<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Attribute
 *
 * @property int $id
 * @property string $attribute_name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductAttributeValue[] $productAttributeValues
 */
class Attribute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attribute_name',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the user that created the attribute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that last updated the attribute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the attribute values for this attribute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,  'product_attributes', 'attribute_id', 'product_id');
    }

    /**
     * Get the attribute values for this attribute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    /**
     * Get the product attribute values for this attribute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productAttributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
