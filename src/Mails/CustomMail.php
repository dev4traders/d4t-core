<?php

namespace D4T\Core\Mails;

use D4T\Core\Models\DomainEmail;
use Illuminate\Support\HtmlString;
use D4T\Core\DomainTemplateMailable;
use Illuminate\Database\Eloquent\Model;
use D4T\Core\Contracts\MailDepartmentInterface;

class CustomMail extends DomainTemplateMailable implements MailDepartmentInterface
{
    public function __construct(
        string $subject,
        private string $body,
        private ?int $userId,
        private ?string $className,
        private int $domainId,
        private int $departmentId,
        private string $emailAddress,
        private string $fromName,
        private string $mainTemplate
    ) {
        $this->subject($subject)->html($body);
    }

    public static function make(string $subject, string $body, ?Model $user, MailDepartmentInterface $dep)
    {
        $class = null;
        $userId = null;

        if (!is_null($user)) {
            $class = get_class($user);
            $userId = $user->id;
        }
        return new static($subject, $body, $userId, $class, $dep->getDomainId(), $dep->getId(), $dep->getAddress(), $dep->getFromName(), $dep->getMainTemplate());
    }

    public function getDomainId(): int
    {
        return $this->domainId;
    }

    public function getAddress(): string
    {
        return $this->emailAddress;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function getMainTemplate(): string
    {
        return $this->mainTemplate;
    }

    public function getId(): int
    {
        return $this->departmentId;
    }

    public function getEmailDepartment(): ?MailDepartmentInterface
    {
        return $this;
    }

    public function build()
    {
        $dep = $this->getEmailDepartment();
        $contextId = $this->userId;
        $contextType = $this->className;

        $this->withSymfonyMessage(function ($message) use ($dep, $contextId, $contextType) {
            $headers = $message->getHeaders();
            $headers->addTextHeader(DomainEmail::HEADER_DOMAIN_ID, $dep->getDomainId());
            $headers->addTextHeader(DomainEmail::HEADER_DEPARTMENT_ID, $dep->getId());

            if (!is_null($contextId))
                $headers->addTextHeader(DomainEmail::HEADER_CONTEXT_ID, $contextId);
            if (!is_null($contextType))
                $headers->addTextHeader(DomainEmail::HEADER_CONTEXT_TYPE, $contextType);
        });

        return $this;
    }

    protected function buildView()
    {
        return array_filter([
            'html' => new HtmlString($this->body),
            'text' => new HtmlString($this->body),
        ]);
    }
}
