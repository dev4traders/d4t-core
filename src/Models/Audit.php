<?php

namespace D4T\Core\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use D4T\Core\Traits\HasCountedEnum;
use OwenIt\Auditing\Models\Audit as BaseModel;

class Audit extends BaseModel
{
    use HasCountedEnum;

    public static function typeCounts(int $userId) : Collection {
        return self::select('auditable_type', DB::raw('COUNT(*) as count'))
        ->groupBy('auditable_type')
        ->where('user_id', $userId)
        ->pluck('count', 'auditable_type');
    }

}