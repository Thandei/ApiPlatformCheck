<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\ApiResource\Normalizer\TranslationNormalizer;
use App\Repository\GenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(
    normalizationContext: ['groups' => ['readGenus']],
    denormalizationContext: ['groups' => ['writeGenus']],
)]
#[ApiFilter(SearchFilter::class, properties: ['user' => 'exact'])]
#[ORM\Entity(repositoryClass: GenusRepository::class)]
class Genus
{
    #[Groups(['readGenus', 'readPet', 'readUser'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['readGenus', 'readPet', 'readUser'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: GenusAttribute::class, inversedBy: 'genera')]
    private Collection $attr;

    #[ORM\OneToMany(mappedBy: 'genus', targetEntity: Pet::class)]
    private Collection $pets;

    public function __construct()
    {
        $this->attr = new ArrayCollection();
        $this->pets = new ArrayCollection();
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

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Pet>
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function addPet(Pet $pet): self
    {
        if (!$this->pets->contains($pet)) {
            $this->pets->add($pet);
            $pet->setGenus($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getGenus() === $this) {
                $pet->setGenus(null);
            }
        }

        return $this;
    }
}
