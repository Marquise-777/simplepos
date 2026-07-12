<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    protected $fillable = [
        'shop_id',
        'business_name',
        'logo',
        'phone',
        'email',
        'address',
        'invoice_prefix',
        'invoice_template',
        'paper_size',
        'currency',
        'timezone',
        'date_format',
        'gst',
        'fssai',
        'footer_text',
        'primary_color',
    ];

    protected function casts(): array
    {
        return [
            //
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
