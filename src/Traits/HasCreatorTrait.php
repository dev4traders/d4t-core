<?php

namespace D4T\Core\Traits;

use D4T\Core\CoreServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCreatorTrait
{

    public function creator() : BelongsTo
    {
        return $this->belongsTo(CoreServiceProvider::getUserModel());
    }

    public function scopeByCreator(Builder $query, int $creatorId): Builder {
        return $query->where('creator_id', $creatorId);
    }
}
