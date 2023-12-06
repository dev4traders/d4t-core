<?php

namespace D4T\Core\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use D4T\Core\Models\NotificationSubscription;
use D4T\Core\NotificationSubscribersNotifier;

trait DispatchesToSubscribers
{
    public static function dispatchToSubscribers()
    {
        Notification::route( NotificationSubscribersNotifier::class, '')->notify(new static(...func_get_args()));
    }

    public static function getSubscribers(int $domainId) : Collection
    {
        return NotificationSubscription::query()
            ->forType(self::class)
            ->forDomain($domainId)
            ->get()
            ->map(fn (NotificationSubscription $notificationSubscription) => (
                $notificationSubscription->user
            ))
            ->filter()
            ->unique();
    }

    public function subscribers() : Collection
    {
        return self::getSubscribers($this->getDomainId());
    }
}
