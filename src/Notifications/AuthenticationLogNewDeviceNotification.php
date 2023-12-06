<?php

namespace D4T\Core\Notifications;

use D4T\Core\DomainMailer;
use D4T\Core\SystemNotification;
use D4T\Core\DomainTemplateMailable;
use D4T\Core\Mails\AuthenticationLogNewDeviceMail;
use D4T\Core\Contracts\EmailContextObjectInterface;
use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog;

class AuthenticationLogNewDeviceNotification extends SystemNotification
{
    public AuthenticationLog $authenticationLog;

    public function __construct(AuthenticationLog $authenticationLog)
    {
        $this->authenticationLog = $authenticationLog;

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

        $location = '';
        if($this->authenticationLog->location && $this->authenticationLog->location['default'] == false) {
            $country = '';
            if(isset($this->authenticationLog->location['country_name']))
                $country = $this->authenticationLog->location['country_name'];
            $city = '';
            if(isset($this->authenticationLog->location['city']))
                $city = $this->authenticationLog->location['city'];
            $location = $country.', '.$city;
        }

        return new AuthenticationLogNewDeviceMail(
                $notifiable->email,
                $this->authenticationLog->login_at->toCookieString(),
                $this->authenticationLog->ip_address,
                $this->authenticationLog->user_agent,
                $location,
                $this
        );
    }

}
