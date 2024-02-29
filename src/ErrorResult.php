<?php

namespace D4T\Core;

use D4T\Core\Contracts\ResultInterface;

abstract class ErrorResult implements ResultInterface
{
    public final function isOk(): bool
    {
        return false;
    }
}