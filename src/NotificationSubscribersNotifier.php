<?php

namespace D4T\Core;

use Illuminate\Notifications\Notification;
use D4T\Core\Contracts\NotifiableInterface;
use D4T\Core\Contracts\SubscribableNotificationInterface;
use D4T\Core\Notifications\NotificationSubscriptionNotification;

class NotificationSubscribersNotifier
{
    public static function handle(NotificationSubscriptionNotification $data, SubscribableNotificationInterface $notification)
    {
        $notification->subscribers()->each(function (NotifiableInterface $user) use ($data) {
            $user->notify($data);
        });
    }

    public function send($notifiable, Notification $notification)
    {

        if (class_implements($notification, SubscribableNotificationInterface::class)) {

            if (method_exists($notification, 'toNotificationSubscribersNotifier')) {
                /** @var mixed $notification */
                $data = $notification->toNotificationSubscribersNotifier($notifiable);

                self::handle($data, (fn ($notification): SubscribableNotificationInterface => $notification)($notification));
            }
        }
    }
}
