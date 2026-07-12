<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'shop_id',
        'plan_name',
        'amount',
        'billing_cycle',
        'starts_at',
        'expires_at',
        'payment_reference',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount'     => 'decimal:2',
            'starts_at'  => 'date',
            'expires_at' => 'date',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
