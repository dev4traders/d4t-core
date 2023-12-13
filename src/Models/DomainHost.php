<?php

namespace D4T\Core\Models;

use D4T\Core\Traits\HasDomain;
use Dcat\Admin\Enums\HttpSchemaType;
use Illuminate\Database\Eloquent\Model;
use D4T\Core\Traits\HasDateTimeFormatter;

class DomainHost extends Model
{
    use HasDateTimeFormatter;
    use HasDomain;

    protected $casts = [
        'schema' => HttpSchemaType::class,
    ];

}
