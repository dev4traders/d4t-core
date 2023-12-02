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

    const TABLE_NAME = 'admin_tags';
    const TABLE_NAME_TAGGABLES = 'admin_taggables';
    const FIELD_NAME_TAGGABLE = 'taggable';

    /**
     * {@inheritDoc}
    */
    public function __construct(array $attributes = [])
    {
        $this->init();

        parent::__construct($attributes);
    }

    protected function init()
    {
        //todo::move to core
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.tags_table') ?: self::TABLE_NAME);
    }

    public function getTag(): string
    {
        return $this->title;
    }

    public function getColor(): string
    {
        return $this->color;
    }
}
