<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'active',
        'free_shipping',
        'rate_type',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
        'free_shipping' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function shippingCountryZones(): HasMany
    {
        return $this->hasMany(ShippingCountryZone::class);
    }

    public function shippingRates(): HasMany
    {
        return $this->hasMany(ShippingRate::class);
    }
}
