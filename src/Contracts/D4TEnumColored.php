<?php

namespace D4T\Core\Contracts;

use D4T\Core\Contracts\D4TEnum;
use D4T\UI\Enums\StyleClassType;

interface D4TEnumColored extends D4TEnum
{
    public function color(): StyleClassType;
}
