<?php

namespace D4T\Core\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use D4T\Core\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpGroup extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'help_groups';

    protected $fillable = ['title'];

    public function category() : BelongsTo
    {
        return $this->belongsTo(HelpCategory::class, 'help_category_id');
    }

    public function posts() : HasMany {
        return $this->hasMany(HelpPost::class, 'help_group_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(HelpGroup $group) {
            $group->key = Str::slug($group->title);
        });

    }
}
