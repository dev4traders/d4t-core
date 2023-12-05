<?php

namespace D4T\Core\Enums;

use D4T\Core\Traits\D4TEnumTrait;
use D4T\UI\Contracts\D4TEnumColored;
use D4T\UI\Enums\StyleClassType;

enum HelpdeskTicketPriority : int implements D4TEnumColored
{

    use D4TEnumTrait;

    case NORMAL = 1;
    case HIGH = 2;

    public function color() : StyleClassType {
        return match($this) {
            self::NORMAL => StyleClassType::INFO,
            self::HIGH => StyleClassType::DANGER,
            default => StyleClassType::PRIMARY
        };
    }
}
