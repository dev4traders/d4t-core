<?php

namespace D4T\Core\Models;

use D4T\Core\Traits\HasDomain;
use D4T\Core\Contracts\ColoredTag;
use Illuminate\Database\Eloquent\Model;
use D4T\Core\Traits\HasDateTimeFormatter;

class Tag extends Model implements ColoredTag
{
    use HasDateTimeFormatter;
    use HasDomain;

    const TABLE_NAME = 'tags';
    const TABLE_NAME_TAGGABLES = 'taggables';
    const FIELD_NAME_TAGGABLE = 'taggable';

    public function getTag(): string
    {
        return $this->title;
    }

    public function getColor(): string
    {
        return $this->color;
    }
}
