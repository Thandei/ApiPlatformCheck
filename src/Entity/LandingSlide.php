<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\ApiResource\Normalizer\TranslatableTextNormalizer;
use App\Repository\LandingSlideRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;

#[ApiResource(
    shortName: 'Landing Slides',
    operations: [
        new GetCollection(
            uriTemplate: '/landing_slides'
        )
    ],
    paginationEnabled: false
)]
#[ORM\Entity(repositoryClass: LandingSlideRepository::class)]
class LandingSlide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Context([TranslatableTextNormalizer::class])]
    #[ORM\Column(length: 40)]
    private ?string $textcontent = null;

    #[Context([TranslatableTextNormalizer::class])]
    #[ORM\Column(length: 255)]
    private ?string $tags = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
