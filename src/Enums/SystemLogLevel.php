<?php

namespace D4T\Core\Enums;

use D4T\Core\Traits\D4TEnumTrait;
use D4T\Core\Contracts\D4TEnumColored;
use Dcat\Admin\Enums\StyleClassType;

enum SystemLogLevel: int implements D4TEnumColored
{

    use D4TEnumTrait;

    case EMERGENCY = 600;
//    case ALERT     = 550;
    case CRITICAL  = 500;
    case ERROR     = 400;
    case WARNING   = 300;
//    case NOTICE    = 250;
    case INFO      = 200;
//    case DEBUG     = 100;

    public function color(): StyleClassType {
        return match ($this) {
            self::INFO => StyleClassType::INFO,
            self::ERROR => StyleClassType::DARK,
            self::CRITICAL=> StyleClassType::DANGER,
            self::WARNING => StyleClassType::WARNING,
            self::EMERGENCY => StyleClassType::PRIMARY,
            default => StyleClassType::SECONDARY
        };

    }
}
