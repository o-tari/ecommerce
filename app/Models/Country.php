<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'iso',
        'name',
        'upper_name',
        'iso3',
        'num_code',
        'phone_code',
    ];

    public function shippingCountryZones(): HasMany
    {
        return $this->hasMany(ShippingCountryZone::class);
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    public function customerAddresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }
}
