<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sale extends Model
{
    use SoftDeletes, HasUuid, HasFactory;

    protected $fillable = [
        'uuid',
        'shop_id',
        'user_id',
        'customer_id',
        'invoice_no',
        'invoice_date',
        'subtotal',
        'discount',
        'tax',
        'grand_total',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'datetime',
        'subtotal'     => 'decimal:2',
        'discount'     => 'decimal:2',
        'tax'          => 'decimal:2',
        'grand_total'  => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
    public function payments(): HasMany
    {
        return $this->hasMany(SalePayment::class);
    }

    public function paymentPlan(): HasOne
    {
        return $this->hasOne(PaymentPlan::class);
    }
}
