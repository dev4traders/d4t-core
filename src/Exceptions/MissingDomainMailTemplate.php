<?php

namespace D4T\Core\Exceptions;

use Exception;
use D4T\Core\DomainTemplateMailable;

class MissingDomainMailTemplate extends Exception
{
    public static function forDomainMailable(DomainTemplateMailable $mailable)
    {
        $mailableClass = class_basename($mailable);
        $domainId = $mailable->getDomainId();

        return new static("No mail template exists for mailable `{$mailableClass}`, domain=`$domainId`");
    }
}
