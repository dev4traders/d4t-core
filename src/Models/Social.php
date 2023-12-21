<?php

namespace D4T\Core\Models;

use D4T\Core\CoreServiceProvider;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'social_logins';

    public function user()
    {
        $model = CoreServiceProvider::getUserModel();
        return $this->belongsTo($model, 'user_id');
    }
}
