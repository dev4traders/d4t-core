<?php

namespace D4T\Core\Jobs;

use D4T\Core\DomainMailer;
use D4T\Core\Jobs\ShouldQueueBase;
use D4T\Core\Mails\CustomMail;

final class SendCustomEmailJob extends ShouldQueueBase
{
    protected $signature = 'emails:send';

    public $timeout = 120;
    public $tries = 5;

    public function __construct(public CustomMail $mailable, public string $to)
    {
        $this->onQueue('emails');
    }

    public function handle()
    {        
        DomainMailer::handle($this->mailable, $this->to);
    }

    public function failed($exception)
    {
        $this->critical($exception);
    }

    public function tags()
    {
        return ['emails', 'emails:'.$this->to];
    }
}
