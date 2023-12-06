<?php

namespace D4T\Core\Traits;

use D4T\Core\Models\NotificationSubscription;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasNotificationSubscriptions
{
    public function notificationSubscriptions(): HasMany
    {
        return $this->hasMany(NotificationSubscription::class, 'user_id');
    }

    public function isSubscribedToNotification($type): bool
    {
        return $this->notificationSubscriptions()
            ->forType($type)
            ->exists();
    }
}
