<?php

namespace D4T\Core\Models;

use Illuminate\Database\Eloquent\Model;
use D4T\Core\Traits\HasDateTimeFormatter;
use D4T\Core\Traits\HasDomain;

class VideoPost extends Model
{
    use HasDateTimeFormatter;
    use HasDomain;

    protected $table = 'video_posts';

    public function scopePublic($query) {
        return $query->where('is_public', 1);
    }

}
