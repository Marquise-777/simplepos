<?php

namespace App\Support;

use App\Models\AdminActivityLog;

class AdminActivity
{
    public static function log(
        string $action,
        ?string $description = null,
        ?int $shopId = null
    ): AdminActivityLog {
        return AdminActivityLog::create([
            'admin_user_id' => auth('admin')->id(),
            'shop_id' => $shopId,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
