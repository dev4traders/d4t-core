<?php

namespace D4T\Core\Models;

use Dcat\Admin\Enums\HttpSchemaType;
use D4T\Core\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends Model
{
    use HasDateTimeFormatter;

    protected $casts = [
        'schema' => HttpSchemaType::class
    ];

    protected $fillable = ['host','manager_id'];

    public function default_roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.domain_role_defaults_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'domain_id', 'role_id')->withTimestamps();
    }

    public function manager() : BelongsTo
    {
        $userModel = config('auth.providers.users.model');
        return $this->belongsTo($userModel, 'manager_id');
    }

    public static function fromRequest() : Domain {
        if(request())
            $host = request()->getHost();
        else
           $host = Str::of(config('app.url'))->remove('http://')->remove('https://');

        $domain = self::whereHost($host)->first();

        if(!$domain)
            throw new \Exception('Domain not setup. Requiested host: '.$host );

        return $domain;
    }

    public function getFullUrlAttribute()
    {
        return $this->schema->value.'://'.$this->host;
    }

}
