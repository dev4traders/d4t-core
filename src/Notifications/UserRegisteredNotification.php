<?php

namespace D4T\Core\Notifications;

use D4T\Core\SystemNotification;
use D4T\Core\Contracts\EmailContextObjectInterface;
use D4T\Core\Notifications\NotificationSubscriptionNotification;

class UserRegisteredNotification extends SystemNotification
{

    public function getContextObject(): ?EmailContextObjectInterface
    {
        return null;
    }

    public function __construct()
    {

        $this->onQueue('default');
    }

    protected function getVia($notifiable) : array
    {
        return [];
    }

    public static function getIcon(): string {
        return 'fa fa-plus';
    }

    public function toNotificationSubscribersNotifier($notifiable) : NotificationSubscriptionNotification {
        return new NotificationSubscriptionNotification(
            $this,
            __('notification.manager.user_registered',
            [
                'user_id' => $notifiable->id,
                'email' => $notifiable->email,
            ]),
            $this->domainId
        );
    }
}