<?php

namespace D4T\Core\Repositories;

class LabelWithCount
{
    public function __construct(public string $label, public string $count) {}
}
