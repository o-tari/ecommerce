<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

/**
 * @property string $id
 * @property string $slug
 * @property string $product_name
 * @property string|null $sku
 * @property float $sale_price
 * @property float $compare_price
 * @property float|null $buying_price
 * @property int $quantity
 * @property string $short_description
 * @property string $product_description
 * @property bool $published
 * @property bool $disable_out_of_stock
 * @property string|null $note
 * @property \App\Models\User|null $createdBy
 * @property \App\Models\User|null $updatedBy
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'product_name',
        'sku',
        'sale_price',
        'compare_price',
        'buying_price',
        'quantity',
        'short_description',
        'product_description',
        'published',
        'disable_out_of_stock',
        'note',
        'created_by',
        'updated_by',
        'product_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sale_price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'buying_price' => 'decimal:2',
        'quantity' => 'integer',
        'published' => 'boolean',
        'disable_out_of_stock' => 'boolean',
        'product_type' => 'string',
    ];

    /**
     * Get the staff account that created the product.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the staff account that updated the product.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'product_suppliers');
    }

    public function variants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Variant::class);
    }

    public function variantOptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VariantOption::class);
    }

    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingInfo(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductShippingInfo::class);
    }

    public function sells(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Sell::class);
    }

    public function cardItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CardItem::class);
    }

    public function productCoupons(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'product_coupons');
    }

    /**
     * Get the product attributes for the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    /**
     * Get the attributes for the product through product attributes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            'product_attributes',
            'product_id',
            'attribute_id'
        );
    }

    /**
     * Get all attribute values for the product via product attributes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributeValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_attribute_values',
            'product_id',
            'attribute_value_id'
        );
    }

    public function registerMediaConversions(?SpatieMedia $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images');
        $this->addMediaCollection('product_thumbnail')->singleFile();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            // Delete related records manually since some migrations use nullOnDelete
            $product->shippingInfo()->delete();
            $product->variants()->delete();
            $product->variantOptions()->delete();
            $product->orderItems()->delete();
            $product->sells()->delete();
            $product->cardItems()->delete();
            $product->productAttributes()->delete();
            // Note: productAttributeValues and variantValues are junction tables with composite primary keys
            // They should be handled by foreign key constraints
        });
    }
}
