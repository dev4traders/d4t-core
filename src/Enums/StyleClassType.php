<?php
declare(strict_types=1);

namespace D4T\Core\Enums;

use D4T\Core\Contracts\D4TEnum;
use D4T\Core\Traits\D4TEnumTrait;

enum StyleClassType : string implements D4TEnum
{
    use D4TEnumTrait;

    case DARK = 'dark';
    case WARNING = 'warning';
    case INFO = 'info';
    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case DANGER = 'danger';
    case SUCCESS = 'success';
}
