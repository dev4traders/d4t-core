<?php

namespace D4T\Core\Notifications;

use D4T\Core\SystemNotification;
use D4T\Core\DomainTemplateMailable;
use D4T\Core\Mails\UserActivatedMail;
use D4T\Core\Contracts\EmailContextObjectInterface;
use D4T\Core\Notifications\NotificationSubscriptionNotification;

class UserActivatedNotification extends SystemNotification
{
    public EmailContextObjectInterface $user;

    public function __construct(EmailContextObjectInterface $user, int $domainId)
    {
        parent::__construct($domainId);

        $this->user = $user;

        $this->onQueue('default');
    }

    public function getContextObject(): ?EmailContextObjectInterface
    {
        return $this->user;
    }

    public function getVia($notifiable): array
    {
        return [];
    }

    public static function getIcon(): string
    {
        return 'fa fa-flag';
    }

    public function toDomainMailer($notifiable): DomainTemplateMailable
    {
        return (
            new UserActivatedMail(
                $this->user->username,
                admin_url('/'),
                $this
            )
        );
    }

    public function toNotificationSubscribersNotifier($notifiable): NotificationSubscriptionNotification
    {
        return new NotificationSubscriptionNotification(
            $this,
            __(
                'notification.manager.user_activated',
                [
                    'user_id' => $this->user->id,
                    'email' => $this->user->username,
                ]
            ),
            $this->domainId
        );
    }
}
