<?php

namespace D4T\Core\Repositories;

use Spatie\LaravelData\Data;
use D4T\Core\SystemNotification;
use Illuminate\Notifications\DatabaseNotification;

class DashboardNotification extends Data {

    function __construct(
        public string $icon,
        public string $title,
        public string $message,
        public string $time,
        public string $style,
        public bool $isRead = false
    ) {

    }

    public static function fromDatabaseNotification(DatabaseNotification $notification) {
        $type = $notification->type;

        $icon = SystemNotification::iconFor($type);
        $title = SystemNotification::labelFor($type);
        $style = SystemNotification::styleFor($type);

        $message = $notification->data['message'];
        $time = $notification->created_at->diffForHumans();
        $isRead = !is_null($notification->read_at);

        return new static($icon, $title, $message, $time, $style, $isRead);
    }

}
