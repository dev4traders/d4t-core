<?php

namespace D4T\Core\Mails;

use D4T\Core\DomainTemplateMailable;
use D4T\Core\Contracts\DomainNotificationWithContextInterface;

class UserActivatedMail extends DomainTemplateMailable
{
    public string $login = 'dummy-login';
    public string $url = 'http://example.com';

    public function __construct( string $login, string $loginUrl, DomainNotificationWithContextInterface $notification)
    {
        $this->login = $login;
        $this->url = $loginUrl;

        parent::__construct($notification);
    }
}
