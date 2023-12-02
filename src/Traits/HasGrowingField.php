<?php

namespace D4T\Core\Traits;

use D4T\Core\Enums\GrowingPerdiodType;
use Carbon\Carbon;
use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait HasGrowingField
{

    public static function getGrowing( GrowingPerdiodType $period, ?\Closure $builder = null, string $dateColumnName = 'created_at') : Collection {
        $field = "DATE($dateColumnName)";

        $query = self::select(DB::raw($field), DB::raw('COUNT(*) as count'))
            ->groupBy($field)
            ->orderBy($field);

        switch($period) {
            case GrowingPerdiodType::TODAY:
                $query->whereDate('created_at', Carbon::today());
                break;
            case GrowingPerdiodType::LAST_WEEK:
                $query->whereDate('created_at', Carbon::today()->subWeek());
                break;
            case GrowingPerdiodType::LAST_MONTH:
                $query->whereDate('created_at', Carbon::today()->subMonth());
                break;
        }
        if($builder !== null)
            call_user_func($builder, $query);

        $counts = $query->pluck('count', $field);

        $growing = 0;
        $data = new Collection();
        foreach($counts as $label => $count) {
            $growing += $count;

            $data[$label] = $growing;
        }
        return $data;
    }

}
