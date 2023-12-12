<?php

namespace D4T\Core\Enums;

use D4T\Core\Traits\D4TEnumTrait;
use D4T\Core\Contracts\D4TEnumColored;
use D4T\Core\Enums\StyleClassType;

enum HelpdeskTicketStatus: int implements D4TEnumColored
{

    use D4TEnumTrait;

    case OPEN = 1;
    case CLOSED = 2;

    public function color() : StyleClassType {
        return match($this) {
            default => StyleClassType::PRIMARY
        };
    }
}
