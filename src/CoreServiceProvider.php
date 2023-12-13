<?php

namespace D4T\Core;

use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use D4T\Core\Models\DomainMailSetting;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        //
    }

    public static function getUserModel() : string {
        return config('auth.providers.users.model');
    }

    public static function getMailer(DomainMailSetting $settings) : Mailer {
        return app()->makeWith('custom.mailer', $settings->toArray());
    }

    public function register()
    {

        $this->app->bind('custom.mailer', function ($app, $parameters) {

            $transport = Mail::createSymfonyTransport($parameters);

            $mailer = new Mailer('custom.mailer', $app->get('view'), $transport, $app->get('events'));

            return $mailer;
        });
    }
}
