<?php

namespace App\Entity;

use App\Repository\GenusAttributeValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenusAttributeValueRepository::class)]
class GenusAttributeValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'genusAttributeValues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pet $pet = null;

    #[ORM\ManyToMany(targetEntity: GenusAttribute::class, inversedBy: 'genusAttributeValues')]
    private Collection $ownerattribute;

    public function __construct()
    {
        $this->ownerattribute = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(?Pet $pet): self
    {
        $this->pet = $pet;

        return $this;
    }

    /**
     * @return Collection<int, GenusAttribute>
     */
    public function getOwnerattribute(): Collection
    {
        return $this->ownerattribute;
    }

    public function addOwnerattribute(GenusAttribute $ownerattribute): self
    {
        if (!$this->ownerattribute->contains($ownerattribute)) {
            $this->ownerattribute->add($ownerattribute);
        }

        return $this;
    }

    public function removeOwnerattribute(GenusAttribute $ownerattribute): self
    {
        $this->ownerattribute->removeElement($ownerattribute);

        return $this;
    }
}
