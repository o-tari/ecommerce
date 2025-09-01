<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password_hash',
        'active',
        'registered_at',
        'updated_at',
    ];

    protected $casts = [
        'active' => 'boolean',
        'registered_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
