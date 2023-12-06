<?php

namespace D4T\Core\Contracts;

use Spatie\MailTemplates\Interfaces\MailTemplateInterface;

interface DomainMailTemplateInterface extends MailTemplateInterface
{
    public function getEmailDepartment(): ?MailDepartmentInterface;
}
