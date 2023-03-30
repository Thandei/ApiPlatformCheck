<?php

namespace App\Entity;

use App\Repository\LandingSlideRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LandingSlideRepository::class)]
class LandingSlide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $textcontent = null;

    #[ORM\Column(length: 255)]
    private ?string $tags = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextcontent(): ?string
    {
        return $this->textcontent;
    }

    public function setTextcontent(string $textcontent): self
    {
        $this->textcontent = $textcontent;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }
}
