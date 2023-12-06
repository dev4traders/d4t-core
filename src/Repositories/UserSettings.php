<?php

namespace D4T\Core\Repositories;

use Spatie\LaravelData\Data;

class UserSettings extends Data
{
    public function __construct(
        public string $timezone = 'UTC',
        public string $locale = 'en',
        public string $date_format = 'YYYY-MM-DD',
    ) {
    }
}
