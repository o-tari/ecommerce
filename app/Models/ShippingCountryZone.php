<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingCountryZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_zone_id',
        'country_id',
    ];

    protected $primaryKey = ['shipping_zone_id', 'country_id'];
    public $incrementing = false;
    public $timestamps = false;

    public function shippingZone(): BelongsTo
    {
        return $this->belongsTo(ShippingZone::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
