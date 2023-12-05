<?php

namespace D4T\Core\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use D4T\Core\Repositories\LabelWithCount;

trait HasCountedEnum
{

    /**
     * @return \Illuminate\Support\Collection<D4TEnum, \D4T\Core\Repositories\LabelWithCount>
     */
    public static function enumCounts(string $fieldName, string $enumClass, ?\Closure $queryCallback = null) : Collection {
        $query = self::select($fieldName, DB::raw('COUNT(*) as count'))
            ->whereIn($fieldName, $enumClass::values())
            ->groupBy($fieldName)
            ->orderBy($fieldName);

        if($queryCallback !== null)
            call_user_func($queryCallback, $query);

        $items = $query->pluck('count', $fieldName);

        $data = new Collection();
        foreach($items as $enum => $count) {
            $label = $enumClass::from($enum)->label();
            $data[$enum] = new LabelWithCount($label, $count);
        }

        return $data;
    }

}
