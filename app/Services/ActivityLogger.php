<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ActivityLogger
{
    public static function log(
        string $action,
        string $description,
        ?Model $subject = null
    ): ActivityLog {
        $request = request();

        return ActivityLog::create([
            'shop_id' => auth()->user()->shop_id,
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
