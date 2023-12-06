<?php

namespace D4T\Core\Mails;

use D4T\Core\DomainTemplateMailable;
use D4T\Core\Contracts\DomainNotificationWithContextInterface;

class AuthenticationLogFailedLoginMail extends DomainTemplateMailable
{
    public string $email = 'dummy@dummy.com';
    public string $time = 'Tue 12:10 12 Jan';
    public string $browser = 'Firefox';
    public string $ip_address = '127.0.0.1';
    public string $location = 'Country, City';

    public function __construct( string $email, string $time, string $ipAddress,string $browser, string $location, DomainNotificationWithContextInterface $notification)
    {
        $this->email = $email;
        $this->time = $time;
        $this->ip_address = $ipAddress;
        $this->browser = $browser;
        $this->location = $location;

        parent::__construct($notification);
    }
}