<?php

namespace D4T\Core\Notifications;

use D4T\Core\DomainMailer;
use Illuminate\Bus\Queueable;
use D4T\Core\SystemNotification;
use D4T\Core\DomainTemplateMailable;
use D4T\Core\Mails\UserActivationRequiredMail;
use D4T\Core\Contracts\EmailContextObjectInterface;

class UserActivationRequiredNotification extends SystemNotification
{
    use Queueable;

    public string $link;

    public function __construct(string $link, int $domainId)
    {
        $this->link = $link;

        parent::__construct($domainId);

        $this->onQueue('default');
    }

    public function getContextObject(): ?EmailContextObjectInterface
    {
        return null;
    }

    protected function getVia($notifiable) : array
    {
        return [DomainMailer::class];
    }

    public function toDomainMailer($notifiable) : DomainTemplateMailable
    {
        return new UserActivationRequiredMail(
                $this->link,
                $this
        );
    }

}
