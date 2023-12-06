<?php

namespace D4T\Core\Contracts;

use D4T\Core\Contracts\EmailContextObjectInterface;

interface DomainNotificationWithContextInterface
{
    public function getDomainId() : int;
    public function getContextObject() : ?EmailContextObjectInterface;
}
