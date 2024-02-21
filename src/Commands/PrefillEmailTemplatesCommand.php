<?php

namespace D4T\Core\Commands;

use D4T\Core\BaseCommand;
use D4T\Core\Models\DomainMailTemplate;

class PrefillEmailTemplatesCommand extends BaseCommand
{
    protected $signature = 'email-templates:prefill';

    protected $description = 'Prefill email templates to domains';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        DomainMailTemplate::fillTypesForDomains();

    }
}
