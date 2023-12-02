<?php

namespace D4T\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasDomain
{
    public function scopeForDomain(Builder $query, int $domainId) : Builder
    {
        return $query->where('domain_id', $domainId);
    }

    public function scopeOwnDomainOnly(Builder $query, int $domainId): Builder {
        return $query->where('domain_id', $domainId);
    }

    public function domain() : BelongsTo
    {
        //todo::move to d4t-core config
        $domainsModel = config('admin.database.domains_model');
        return $this->belongsTo($domainsModel, 'domain_id');
    }

}
