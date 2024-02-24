<?php

namespace D4T\Core\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use D4T\Core\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpPost extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'help_posts';
    public const ROUTE_PATH = 'help';

    public function group() : BelongsTo
    {
        return $this->belongsTo(HelpGroup::class, 'help_group_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(HelpPost $post) {
            $post->key = Str::slug($post->title);
        });
    }

    public static function getLink(?int $postId = null) : string {

        if(!function_exists('admin_url')) {
            return '';
        }

        $url = admin_url(static::ROUTE_PATH);

        if(!$postId)
            return $url;

        $helpPost = self::with(['group:id,key,help_category_id', 'group.category:id,key'])->find($postId);

        if($helpPost)
            $url = $helpPost->link;

        return $url;
    }

    public function getLinkAttribute() : string
    {
        if(!function_exists('admin_url')) {
            return '';
        }

        $url = admin_url(static::ROUTE_PATH);
        return $url.'/'.$this->group->category->key.'/'.$this->group->key.'/'.$this->key;
    }

}
