<?php

namespace D4T\Core\Commands;

use Carbon\Carbon;
use D4T\Core\BaseCommand;
use D4T\Core\Models\Domain;
use D4T\Core\Models\DomainHost;
use D4T\Core\Enums\HttpSchemaType;

class AddDomainCommand extends BaseCommand
{
    protected $signature = 'domains:add {--host=}';

    protected $description = 'Add domain with hosts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $host = $this->option('host');

        if (empty($host))
            return;

        if (Domain::where('host_base', $host)->exists())
            return;

        $domain = new Domain();

        $domain->host_base = $host;
        $domain->manager_id = 1;
        $domain->created_at = Carbon::now();
        $domain->updated_at = Carbon::now();

        $domain->save();

        $domainHost = new DomainHost();

        $domainHost->domain_id = $domain->id;

        $domainHost->host = $host;
        $domainHost->app = 'admin';
        $domainHost->schema = HttpSchemaType::HTTPS;

        $domainHost->created_at = Carbon::now();
        $domainHost->updated_at = Carbon::now();

        $domainHost->save();
    }
}
