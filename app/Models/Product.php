<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
        return $this->belongsToMany(Category::class, 'product_categories');
    }
}
