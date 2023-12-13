<?php

//todo::add all notofications to system. funded.php config
namespace D4T\Core\Notifications;

use D4T\Core\DomainMailer;
use Dcat\Admin\Models\Domain;
use Illuminate\Bus\Queueable;
use D4T\Core\SystemNotification;
use D4T\Core\Mails\UserCreatedMail;
use D4T\Core\DomainTemplateMailable;
use D4T\Core\Contracts\EmailContextObjectInterface;
use D4T\Core\Notifications\NotificationSubscriptionNotification;

class UserCreatedNotification extends SystemNotification
{
    use Queueable;

    public string $openPassword;

    public function __construct(string $openPassword, int $domainId)
    {
        parent::__construct($domainId);

        $this->openPassword = $openPassword;

        $this->onQueue('default');
    }

    public function getContextObject(): ?EmailContextObjectInterface
    {
        return null;
    }

    public function getVia($notifiable): array
    {
        return [DomainMailer::class];
    }

    public function toDatabase($notifiable)
    {
        return ['message' => __(
            'notification.manager.user_created',
            [
                'username' => $notifiable->username,
                'name' => $notifiable->name,
                'email' => $notifiable->email,
            ]
        )];
    }

    public function toDomainMailer($notifiable): DomainTemplateMailable
    {
        $domain = Domain::find($notifiable->domain_id);

        return (
            new UserCreatedMail(
                $notifiable->username,
                $notifiable->email,
                $notifiable->name,
                $this->openPassword,
                $domain->getFullUrlAttribute(),
                $this
            )
        );
    }

    public static function getIcon(): string
    {
        return 'fa fa-user-circle';
    }

    public function toWebhookNotifier($notifiable): array
    {
        return [
            'id' => $notifiable->id,
            'username' => $notifiable->username,
            'name' => $notifiable->name,
            'email' => $notifiable->email,
            'created_at' => $notifiable->created_at,
            'updated_at' => $notifiable->updated_at,
        ];
    }

    public function toNotificationSubscribersNotifier($notifiable): NotificationSubscriptionNotification
    {
        return new NotificationSubscriptionNotification(
            $this,
            __(
                'notification.manager.user_created',
                [
                    'username' => $notifiable->username,
                    'email' => $notifiable->email,
                    'name' => $notifiable->name
                ]
            ),
            $this->domainId
        );
    }
}
