<?php

namespace D4T\Core\Enums;

use D4T\Core\Contracts\D4TEnum;
use D4T\Core\Traits\D4TEnumTrait;

enum StyleBgClassType : string implements D4TEnum
{
    use D4TEnumTrait;

    case DARK = 'bg-dark';
    case WARNING = 'bg-warning';
    case INFO = 'bg-info';
    case PRIMARY = 'bg-primary';
    case SECONDARY = 'bg-secondary';
    case DANGER = 'bg-danger';
    case SUCCESS = 'bg-success';
}
