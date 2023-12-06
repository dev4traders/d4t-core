<?php

namespace D4T\Core\Traits;

use D4T\Core\Models\Domain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasDomain
{
    public function scopeForDomain(Builder $query, int $domainId) : Builder
    {
        return $query->where('domain_id', $domainId);
    }

    public function domain() : BelongsTo
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

}
