<?php


namespace D4T\Core\Contracts;

use Illuminate\Support\Collection;

interface SubscribableNotificationInterface
{
    public function subscribers() : Collection;

    public function label() : string;

    public function getDomainId() : int;
}
