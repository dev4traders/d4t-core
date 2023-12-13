<?php

namespace D4T\Core\Traits;

use Illuminate\Support\Facades\Cache;

trait CanBeOnlineTrait
{
    public static function getCountOnline(): int
    {
        $online = 0;

        $users = Cache::get('online-users');

        if (!is_null($users)) {
            $online = count((array)$users);
        }

        return $online;
    }

    public function getIsOnlineAttribute(): bool
    {
        $users = Cache::get('online-users');

        if (!$users) return false;

        $onlineUsers = collect($users);

        $onlineUser = $onlineUsers->firstWhere('id', $this->id);

        return $onlineUser && ($onlineUser['last_activity_at'] >= now()->subMinutes(config('funded.active_minites')));
    }

}
