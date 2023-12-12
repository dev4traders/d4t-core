<?php

namespace D4T\Core\Enums;

use D4T\Core\Enums\StyleClassType;
use D4T\Core\Traits\D4TEnumTrait;
use D4T\Core\Contracts\D4TEnumColored;

enum EmailDirectionType: int implements D4TEnumColored
{
    use D4TEnumTrait;

    case IN = 1;
    case OUT = 2;
    case REPLY = 3;

    public function color(): StyleClassType
    {
        return match ($this) {
            self::IN    => StyleClassType::PRIMARY,
            self::OUT   => StyleClassType::SECONDARY,
            self::REPLY => StyleClassType::INFO,
            default     => StyleClassType::DARK
        };
    }
}
