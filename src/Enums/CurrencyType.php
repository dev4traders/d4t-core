<?php

namespace D4T\Core\Enums;

use D4T\Core\Contracts\D4TEnum;
use D4T\Core\Traits\D4TEnumTrait;

enum CurrencyType: string implements D4TEnum
{
    use D4TEnumTrait;

    case USD = 'USD';
    case EUR = 'EUR';
    case POUND = 'POUND';
    case BTC = 'BTC';
    case BRL = 'BRL';
}
