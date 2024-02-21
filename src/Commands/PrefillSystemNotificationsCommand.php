<?php

namespace D4T\Core\Commands;

use D4T\Core\BaseCommand;
use D4T\Core\Models\SystemNotificationSetting;

class PrefillSystemNotificationsCommand extends BaseCommand
{
    protected $signature = 'system-notifications:prefill';

    protected $description = 'Prefill system notification settings to domains';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        SystemNotificationSetting::fillTypesForDomains();

    }
}
