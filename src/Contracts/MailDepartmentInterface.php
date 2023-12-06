<?php

namespace D4T\Core\Contracts;

interface MailDepartmentInterface
{
    public function getId(): int;

    public function getDomainId(): int;

    public function getAddress(): string;

    public function getFromName(): string;

    public function getMainTemplate(): string;
}
