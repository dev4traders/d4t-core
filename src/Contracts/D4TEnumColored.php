<?php

namespace D4T\Core\Contracts;

interface D4TEnumColored extends D4TEnum
{
    public function color(): string;
}
