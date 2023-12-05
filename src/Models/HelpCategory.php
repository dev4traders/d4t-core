<?php

namespace D4T\Core\Models;

use Illuminate\Support\Str;
use D4T\Core\Models\HelpPost;
use Dcat\Admin\Models\Domain;
use D4T\Core\Models\HelpGroup;
use Illuminate\Database\Eloquent\Model;
use D4T\Core\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class HelpCategory extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'help_categories';

    public function domain() : BelongsTo
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    public function groups() : HasMany
    {
        return $this->hasMany(HelpGroup::class, 'help_category_id');
    }

    public function posts() : HasManyThrough
    {
        return $this->hasManyThrough(HelpPost::class, HelpGroup::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(HelpCategory $category) {
            $category->key = Str::slug($category->title);
        });

    }
}
