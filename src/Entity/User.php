<?php namespace App\Entity;
use ApiPlatform\Doctrine\Odm\Filter\DateFilter;
use ApiPlatform\Doctrine\Odm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['readUser']],
    denormalizationContext: ['groups' => ['writeUser']],
    paginationItemsPerPage: 20
)]
#[ApiFilter(DateFilter::class, properties: ['dateProperty'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'email' => 'exact', 'accountname' => 'partial'])]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['readUser'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['readUser'])]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['readUser'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accountname = null;

    #[Groups(['readUser'])]
    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $nickname = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[Groups(['readUser'])]
    #[ORM\Column(nullable: true)]
    private ?bool $approvalbadge = null;

    #[Groups(['readUser'])]
    #[ORM\Column(nullable: true)]
    private ?bool $hasbusiness = null;

    #[Groups(['readUser'])]
    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Locale $defaultlocale = null;

    #[ORM\OneToMany(mappedBy: 'uploadedby', targetEntity: MediaObject::class)]
    private Collection $mediaObjects;

    #[Groups(['readUser'])]
    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Pet::class)]
    private Collection $pets;

    public function __construct()
    {
        $this->mediaObjects = new ArrayCollection();
        $this->pets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAccountname(): ?string
    {
        return $this->accountname;
    }

    public function setAccountname(?string $accountname): self
    {
        $this->accountname = $accountname;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new DateTimeImmutable();
    }

    public function isApprovalbadge(): ?bool
    {
        return $this->approvalbadge;
    }

    public function setApprovalbadge(?bool $approvalbadge): self
    {
        $this->approvalbadge = $approvalbadge;

        return $this;
    }

    public function isHasbusiness(): ?bool
    {
        return $this->hasbusiness;
    }

    public function setHasbusiness(?bool $hasbusiness): self
    {
        $this->hasbusiness = $hasbusiness;

        return $this;
    }

    public function getDefaultlocale(): ?Locale
    {
        return $this->defaultlocale;
    }

    public function setDefaultlocale(?Locale $defaultlocale): self
    {
        $this->defaultlocale = $defaultlocale;

        return $this;
    }

    /**
     * @return Collection<int, MediaObject>
     */
    public function getMediaObjects(): Collection
    {
        return $this->mediaObjects;
    }

    public function addMediaObject(MediaObject $mediaObject): self
    {
        if (!$this->mediaObjects->contains($mediaObject)) {
            $this->mediaObjects->add($mediaObject);
            $mediaObject->setUploadedby($this);
        }

        return $this;
    }

    public function removeMediaObject(MediaObject $mediaObject): self
    {
        if ($this->mediaObjects->removeElement($mediaObject)) {
            // set the owning side to null (unless already changed)
            if ($mediaObject->getUploadedby() === $this) {
                $mediaObject->setUploadedby(null);
            }
        }

        return $this;
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
            $pet->setOwner($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getOwner() === $this) {
                $pet->setOwner(null);
            }
        }

        return $this;
    }


}
