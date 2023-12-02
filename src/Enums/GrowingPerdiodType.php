<?php

namespace D4T\Core\Enums;

use D4T\Core\Contracts\D4TEnum;
use D4T\Core\Traits\D4TEnumTrait;

enum GrowingPerdiodType: int implements D4TEnum
{

    use D4TEnumTrait;

    case ALL = 0;
    case TODAY = 1;
    case LAST_WEEK = 7;
    case LAST_MONTH = 30;

}
