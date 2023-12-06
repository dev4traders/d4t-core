<?php

namespace D4T\Core\Notifications;

use Illuminate\Bus\Queueable;
use D4T\Core\DomainTemplateMailable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use D4T\Core\Mails\NotificationSubscriptionMail;
use D4T\Core\Contracts\EmailContextObjectInterface;
use D4T\Core\Contracts\SubscribableNotificationInterface;
use D4T\Core\Contracts\DomainNotificationWithContextInterface;

class NotificationSubscriptionNotification extends Notification implements ShouldQueue, DomainNotificationWithContextInterface
{
    use Queueable;

    public string $title;
    public string $message;
    public int $domainId;

    public function __construct(SubscribableNotificationInterface $notification, string $message, int $domainId)
    {
        $this->title = $notification->label();

        $this->message = $message;
        $this->domainId = $domainId;

        $this->onQueue('default');
    }

    public function getDomainId(): int
    {
        return $this->domainId;
    }

    public function getContextObject(): ?EmailContextObjectInterface
    {
        return null;
    }

    public function via($notifiable)
    {
        return [DomainMailer::class, 'database'];
    }

    public function toDomainMailer($notifiable) : DomainTemplateMailable
    {
        return (
            new NotificationSubscriptionMail(
                $this->title,
                $this->message,
                $this
            )
        );
    }

    public function toArray($notifiable) {
        return ['message' => $this->title.' : '.$this->message];
    }

}
