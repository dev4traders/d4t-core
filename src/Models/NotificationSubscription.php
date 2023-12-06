<?php

namespace D4T\Core\Models;

use D4T\Core\CoreServiceProvider;
use D4T\Core\Traits\HasDomain;
use Illuminate\Database\Eloquent\Model;

class NotificationSubscription extends Model
{
    use HasDomain;

    protected $fillable = ['type', 'user_id', 'domain_id', 'created_at', 'updated_at'];

    public function user()
    {
        $model = CoreServiceProvider::getUserModel();
        return $this->belongsTo($model);
    }

    public function scopeForType($query, $type)
    {
        $query->where('type', $type);
    }

}
