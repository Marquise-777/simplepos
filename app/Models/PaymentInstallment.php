<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentInstallment extends Model
{
    protected $fillable = [
        'payment_plan_id',
        'due_date',
        'amount',
        'paid_amount',
        'status',
        'paid_at',
        'notification_read_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'notification_read_at' => 'datetime',
    ];

    public function paymentPlan(): BelongsTo
    {
        return $this->belongsTo(PaymentPlan::class);
    }
}
