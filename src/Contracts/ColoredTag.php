<?php

namespace D4T\Core\Contracts;

interface ColoredTag
{
    public function getTag() : string;
    public function getColor() : string;
}
