<?php

namespace D4T\Core\Listeners;

use D4T\Core\Models\DomainEmail;
use Illuminate\Mail\Events\MessageSent;

class LogSentMailListener
{
    public function __construct()
    {
        //
    }

    public function handle(MessageSent $event)
    {
        DomainEmail::saveFromSymfonySentMessage($event->sent->getSymfonySentMessage());
    }
}

