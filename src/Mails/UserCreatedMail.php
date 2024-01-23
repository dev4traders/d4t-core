<?php

namespace D4T\Core\Mails;

use D4T\Core\DomainTemplateMailable;
use D4T\Core\Contracts\DomainNotificationWithContextInterface;

class UserCreatedMail extends DomainTemplateMailable
{
    public string $user_name = 'login';
    public string $email = '1@1.com';
    public string $name = 'Marcus';
    public string $password = 'secret';

    public function __construct( string $userName, string $email, string $name, string $password, DomainNotificationWithContextInterface $notification)
    {
        $this->user_name = $userName;
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;

        parent::__construct($notification);
    }

}
