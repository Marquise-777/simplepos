<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_user_id',
        'shop_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
    ];

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
