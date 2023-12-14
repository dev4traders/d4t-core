<?php

namespace D4T\Core\Enums;

use D4T\Core\Contracts\D4TEnum;
use D4T\Core\Traits\D4TEnumTrait;

enum LayoutDirectionType : string implements D4TEnum
{
    use D4TEnumTrait;

    case LTR = 'ltr';
    case RTL = 'rtl';
}
