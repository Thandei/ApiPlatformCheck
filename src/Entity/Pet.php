<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(

    normalizationContext: ['groups' => ['readPet']],
    denormalizationContext: ['groups' => ['writePet']],
    paginationItemsPerPage: 5
)]
#[ORM\Entity(repositoryClass: PetRepository::class)]

class Pet
{
    #[Groups(['readPet', 'readUser'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ Assert\NotBlank, Groups(['readPet', 'readUser'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['readPet', 'readUser'])]
    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genus $genus = null;
    #[ORM\OneToMany(mappedBy: 'pet', targetEntity: GenusAttributeValue::class)]
    private Collection $genusAttributeValues;

    public function __construct()
    {
        $this->genusAttributeValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
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

    public function getGenus(): ?Genus
    {
        return $this->genus;
    }

    public function setGenus(?Genus $genus): self
    {
        $this->genus = $genus;

        return $this;
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
            $genusAttributeValue->setPet($this);
        }

        return $this;
    }

    public function removeGenusAttributeValue(GenusAttributeValue $genusAttributeValue): self
    {
        if ($this->genusAttributeValues->removeElement($genusAttributeValue)) {
            // set the owning side to null (unless already changed)
            if ($genusAttributeValue->getPet() === $this) {
                $genusAttributeValue->setPet(null);
            }
        }

        return $this;
    }

}
