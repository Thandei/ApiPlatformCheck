<?php

namespace App\Entity;

use App\Repository\SystemLogRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: SystemLogRepository::class)]
class SystemLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'system_log_priority')]
    private $priority = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $requestip = null;

    #[ORM\Column(nullable: true)]
    private ?int $relateduserid = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $trace = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new DateTimeImmutable();
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRequestip(): ?string
    {
        return $this->requestip;
    }

    public function setRequestip(?string $requestip): self
    {
        $this->requestip = $requestip;

        return $this;
    }

    public function getRelateduserid(): ?int
    {
        return $this->relateduserid;
    }

    public function setRelateduserid(?int $relateduserid): self
    {
        $this->relateduserid = $relateduserid;

        return $this;
    }

    public function getTrace(): ?string
    {
        return $this->trace;
    }

    public function setTrace(?string $trace): self
    {
        $this->trace = $trace;

        return $this;
    }
}
