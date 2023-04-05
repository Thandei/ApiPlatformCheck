<?php

namespace App\Entity;

use App\Repository\GenusAttributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenusAttributeRepository::class)]
class GenusAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $unit = null;

    #[ORM\ManyToMany(targetEntity: Genus::class, mappedBy: 'attr')]
    private Collection $genera;

    #[ORM\ManyToMany(targetEntity: GenusAttributeValue::class, mappedBy: 'ownerattribute')]
    private Collection $genusAttributeValues;

    public function __construct()
    {
        $this->genera = new ArrayCollection();
        $this->genusAttributeValues = new ArrayCollection();
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

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }


    public function addGenus(Genus $genus): self
    {
        if (!$this->genera->contains($genus)) {
            $this->genera->add($genus);
            $genus->addAttr($this);
        }

        return $this;
    }

    public function removeGenus(Genus $genus): self
    {
        if ($this->genera->removeElement($genus)) {
            $genus->removeAttr($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, GenusAttributeValue>
     */
    public function getGenusAttributeValues(): Collection
    {
        return $this->genusAttributeValues;
    }

    public function addGenusAttributeValue(GenusAttributeValue $genusAttributeValue): self
    {
        if (!$this->genusAttributeValues->contains($genusAttributeValue)) {
            $this->genusAttributeValues->add($genusAttributeValue);
            $genusAttributeValue->addOwnerattribute($this);
        }

        return $this;
    }

    public function removeGenusAttributeValue(GenusAttributeValue $genusAttributeValue): self
    {
        if ($this->genusAttributeValues->removeElement($genusAttributeValue)) {
            $genusAttributeValue->removeOwnerattribute($this);
        }

        return $this;
    }
}
