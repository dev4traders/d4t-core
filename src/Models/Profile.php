<?php

namespace D4T\Core\Models;

use D4T\Core\CoreServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $table = 'user_profiles';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'location',
        'bio',
        'twitter_username',
        'github_username',
        'user_profile_bg',
        'avatar',
        'avatar_status',
    ];

    public function user() : BelongsTo
    {
        $model = CoreServiceProvider::getUserModel();
        return $this->belongsTo($model);
    }

}
