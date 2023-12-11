<?php

namespace D4T\Core\Mails;

use D4T\Core\DomainTemplateMailable;
use D4T\Core\Contracts\DomainNotificationWithContextInterface;

class UserActivationRequiredMail extends DomainTemplateMailable
{
    public string $link = '/activate/123123';

    public function __construct( string $link, DomainNotificationWithContextInterface $notification)
    {
        $this->link = $link;

        parent::__construct($notification);
    }
}
