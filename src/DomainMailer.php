<?php

namespace D4T\Core;

use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use D4T\Core\Models\DomainMailSetting;
use Illuminate\Notifications\Notification;

class DomainMailer {

    public static function handle(DomainTemplateMailable $mailable, string $to, ?DomainMailSetting $setting = null)
    {
        if (is_null($setting))
            $setting = DomainMailSetting::with('default_department')->find($mailable->getDomainId());

            /** @var MailDepartmentInterface $dep */
            $dep = $mailable->getEmailDepartment();

            if (!is_null($setting)) {

                if ($setting->disabled_temporary) {
                    Mail::mailer('log')->to($to)->send($mailable);
                    Log::warning('Email sending temporary disabled', ['subject' => $mailable->subject, 'data' => $mailable->buildViewData()]);
                    return;
                }

                if(is_null($dep)) {
                    $dep = $setting->default_department;
                }

                if (!empty($dep->getMainTemplate()))
                    $mailable->setLayout($dep->getMainTemplate());

                /** @var Mailer $mailer */
                $mailer = CoreServiceProvider::getMailer($setting);

                $mailer->alwaysFrom($dep->getAddress(), $dep->getFromName());
                $mailer->alwaysReplyTo($dep->getAddress(), $dep->getFromName());

                $mailer->to($to)->send($mailable);
        } else {
            Log::critical('DomainMailSetting not found, using default mailer', ['to' => $to]);
            Mail::mailer('log')->to($to)->send($mailable);
            //Mail::to($to)->send($mailable);
        }
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {

        if (method_exists($notifiable, 'routeNotificationFor')) {
            $email = $notifiable->routeNotificationFor('DomainMailer', $notification);

            if (!is_null($email) && method_exists($notification, 'toDomainMailer')) {

                /** @var DomainTemplateMailable $mailable */
                /** @var mixed $notification */
                $mailable = $notification->toDomainMailer($notifiable);

                if ($mailable instanceof DomainTemplateMailable) {
                    DomainMailer::handle($mailable, $email);
                } else {
                    Log::critical('mailable not implemented DomainTemplateMailable', ['class' => class_basename($mailable)]);
                }
            }
        }
    }
}
