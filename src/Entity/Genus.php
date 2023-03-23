<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\ApiResource\Context\Translation\GenusName;
use App\ApiResource\Normalizer\TranslationNormalizer;
use App\Repository\GenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;


#[ApiResource]
#[ORM\Entity(repositoryClass: GenusRepository::class)]
class Genus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: GenusAttribute::class, inversedBy: 'genera')]
    private Collection $attr;

    public function __construct()
    {
        $this->attr = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, GenusAttribute>
     */
    public function getAttr(): Collection
    {
        return $this->attr;
    }

    public function addAttr(GenusAttribute $attr): self
    {
        if (!$this->attr->contains($attr)) {
            $this->attr->add($attr);
        }

        return $this;
    }

    public function removeAttr(GenusAttribute $attr): self
    {
        $this->attr->removeElement($attr);

        return $this;
    }
}
