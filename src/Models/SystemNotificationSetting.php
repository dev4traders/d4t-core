<?php
namespace D4T\Core\Models;

use Carbon\Carbon;
use D4T\Core\Traits\HasDomain;
use Illuminate\Database\Eloquent\Model;

class SystemNotificationSetting extends Model {

    use HasDomain;
    //use Cachable; // todo::move to child project

    const TABLE_NAME = 'system_notification_settings';

    public static function fillTypesForDomains() : void {
        $types = config('admin.system_notification_types');

        /** @var mixed $domains */
        $domains = Domain::all();

        collect($types)->each(function ($type) use($domains) {
            $domains->each( function($domain) use($type) {

                self::insertOrIgnore([
                    'domain_id' => $domain->id,
                    'type' => $type,
                    'send_email' => 1,
                    'send_notification' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } );
        });
    }

    //moved to Systemnotification::labelFor
    // public static function getTypeFromClass(string $className) : string {
    //     return Str::remove('App\\Notifications\\', $className);
    // }

    // public static function getTitle(string $className) : string {
    //     return __('admin.notification.'.self::getTypeFromClass($className));
    // }
}
