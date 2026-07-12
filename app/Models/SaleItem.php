<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'item_name',
        'quantity',
        'rate',
        'amount',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'rate'     => 'decimal:2',
            'amount'   => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}
