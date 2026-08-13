<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentPlan extends Model
{
    protected $fillable = [
        'sale_id',
        'type',
        'financer_name',
        'down_payment',
        'principal_amount',
        'total_payable',
        'installment_amount',
        'installment_count',
        'frequency',
        'start_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'down_payment' => 'decimal:2',
        'principal_amount' => 'decimal:2',
        'total_payable' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'start_date' => 'date',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(PaymentInstallment::class);
    }
}
