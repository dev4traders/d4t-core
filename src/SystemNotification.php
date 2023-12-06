<?php

namespace D4T\Core;

use D4T\Core\DomainMailer;
use Illuminate\Bus\Queueable;
use D4T\UI\Enums\StyleClassType;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use D4T\Core\Traits\DispatchesToSubscribers;
use D4T\Core\Models\SystemNotificationSetting;
use D4T\Core\Contracts\SubscribableNotificationInterface;
use D4T\Core\Contracts\DomainNotificationWithContextInterface;

abstract class SystemNotification extends Notification implements ShouldQueue, SubscribableNotificationInterface, DomainNotificationWithContextInterface
{
    use Queueable;
    use DispatchesToSubscribers; //todo:: move to child class

    public int $domainId;

    protected string $viaBase = ''; // todo::move to child NotificationSubscribersNotifier::class;

    public function getDomainId() : int {
        return $this->domainId;
    }

    public function __construct(int $domainId)
    {
        $this->domainId = $domainId;

        $this->onQueue('default');
    }

    protected abstract function getVia($notifiable) : array;

    public function via($notifiable)
    {
        $via = [$this->viaBase];

        $setting = SystemNotificationSetting::forDomain($this->domainId)->where('type', static::class)->first();

        if(!is_null($setting)) {
            if($setting->send_email) {
                $via[] = DomainMailer::class;
            }

            if($setting->send_notification) {
                $via[] = 'database';
            }
        }

        return array_unique(array_merge($this->getVia($notifiable), $via));
    }

    public static function getStyle() : StyleClassType {
        return StyleClassType::PRIMARY;
    }

    public static function getIcon() : string {
        return 'fas fa-user-circle';
    }

    public static function labelFor(string $type): string
    {
        $lang_key = 'notifications.'.$type;

        return app('translator')->has($lang_key) ? __($lang_key) : $type;
    }

    public function label(): string
    {
        return static::labelFor(static::class);
    }

    public static function iconFor(string $type): string
    {
        //todo::move to settings, use interfaces
        return $type::getIcon();
    }

    public function icon(): string
    {
        return static::iconFor(static::class);
    }

    public static function styleFor(string $type): string
    {
        //todo::move to settings, use interfaces
        return $type::getStyle()->value;
    }

    public function style(): string
    {
        return static::styleFor(static::class);
    }
}
