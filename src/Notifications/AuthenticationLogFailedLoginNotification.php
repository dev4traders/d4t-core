<?php

namespace D4T\Core\Notifications;

use D4T\Core\DomainMailer;
use Illuminate\Bus\Queueable;
use D4T\Core\SystemNotification;
use D4T\Core\DomainTemplateMailable;
use D4T\Core\Contracts\EmailContextObjectInterface;
use D4T\Core\Mails\AuthenticationLogFailedLoginMail;
use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog;

class AuthenticationLogFailedLoginNotification extends SystemNotification
{
    use Queueable;

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
            $country = $this->authenticationLog->location['country_name'];
            $city = $this->authenticationLog->location['city'];
            $location = $country.', '.$city;
        }

        return new AuthenticationLogFailedLoginMail(
                $notifiable->email,
                $this->authenticationLog->login_at->toCookieString(),
                $this->authenticationLog->ip_address,
                $this->authenticationLog->user_agent,
                $location,
                $this
        );
    }

}