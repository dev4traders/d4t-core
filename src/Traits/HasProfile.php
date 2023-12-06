<?php

namespace D4T\Core\Traits;

use D4T\Core\Models\Social;
use D4T\Core\Models\Profile;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasProfile
{
    public function social(): HasMany
    {
        return $this->hasMany(Social::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

}
