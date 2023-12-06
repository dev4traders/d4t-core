<?php

namespace D4T\Core\Traits;

use Illuminate\Support\Collection;
use D4T\Core\Repositories\DashboardNotification;
use Illuminate\Notifications\DatabaseNotification;

trait HasDashboardNotifications
{
    public function dashboardNotifications(int $top = 10): Collection
    {
        $notifications = DatabaseNotification::take($top)
            ->unread()
            ->where('notifiable_id', $this->id)
            ->get();

        return $notifications->map(function(DatabaseNotification $notification) {
            return DashboardNotification::fromDatabaseNotification($notification);
        });
    }

}
