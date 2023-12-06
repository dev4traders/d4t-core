<?php

namespace D4T\Core\Mails;

use D4T\Core\DomainTemplateMailable;
use D4T\Core\Contracts\DomainNotificationWithContextInterface;

class NotificationSubscriptionMail extends DomainTemplateMailable
{
    public string $event = 'event';
    public string $details = 'details';

    public function __construct( string $event, string $details, DomainNotificationWithContextInterface $notification)
    {
        $this->event = $event;
        $this->details = $details;

        parent::__construct($notification);
    }

}
