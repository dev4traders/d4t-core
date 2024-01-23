<?php

namespace D4T\Core\Models;

use Illuminate\Support\Str;
use D4T\Core\CoreServiceProvider;
use Illuminate\Database\Eloquent\Model;
use D4T\Core\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Domain extends Model
{
    use HasDateTimeFormatter;

    protected string $app;

    public function setApp(string $app) : Domain {
        $this->app = $app;

        return $this;
    }

    public function getApp() : string {
        return $this->app;
    }

    protected $fillable = ['host_base','manager_id'];

    public function default_roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.domain_role_defaults_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'domain_id', 'role_id')->withTimestamps();
    }

    public function manager() : BelongsTo
    {
        $userModel = CoreServiceProvider::getUserModel();
        return $this->belongsTo($userModel, 'manager_id');
    }

    public function hosts() : HasMany {
        return $this->hasMany(DomainHost::class, 'domain_id');
    }

    public static function fromRequest() : Domain {
        if(request())
            $hostName = request()->getHost();
        else
           $hostName = Str::of(config('app.url'))->remove('http://')->remove('https://');

        $host = DomainHost::with('domain')->where('host', $hostName)->first();

        if(!$host)
            throw new \Exception('Host not setup. Requiested host: '.$hostName );

        $host->domain->setApp($host->app);

        return $host->domain;
    }

    public function getFullUrlAttribute()
    {
        return $this->host;
        //return $this->schema->value.'http://'.$this->host;
    }

}
