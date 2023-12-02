<?php

namespace D4T\Core\Enums;

use D4T\Core\Contracts\D4TEnum;
use D4T\Core\Traits\D4TEnumTrait;

enum YesNoType: int implements D4TEnum
{
    use D4TEnumTrait;

    case NO = 0;
    case YES = 1;
}
