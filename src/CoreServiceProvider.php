<?php

namespace D4T\Core;

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
}
