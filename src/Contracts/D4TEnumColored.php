<?php

namespace D4T\Core\Contracts;

use Dcat\Admin\Enums\StyleClassType;

interface D4TEnumColored extends D4TEnum
{
    public function color(): StyleClassType;
}
