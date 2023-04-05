<?php

namespace App\Entity;

use App\Repository\GenusAttributeValueRepository;
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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?GenusAttribute $attribute = null;

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

    public function getAttribute(): ?GenusAttribute
    {
        return $this->attribute;
    }

    public function setAttribute(GenusAttribute $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }
}
