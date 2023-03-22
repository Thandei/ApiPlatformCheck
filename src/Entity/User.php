<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new Patch()
    ]
)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ApiProperty(readable: false, writable: false)]
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ApiProperty(readable: false)]
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accountname = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $nickname = null;

    #[ApiProperty(readable: false, writable: false, readableLink: false)]
    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    #[ApiProperty(readable: true, writable: false)]
    private ?bool $approvalbadge = null;
    #[ApiProperty(readable: true, writable: false)]
    #[ORM\Column(nullable: true)]
    private ?bool $hasbusiness = null;

    #[ORM\OneToOne(targetEntity: MediaObject::class, cascade: ['persist', 'remove'])]
    #[ApiProperty(writable: false, readableLink: true)]
    #[ORM\JoinColumn(nullable: true)]
    private ?MediaObject $image = null;

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

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): self
    {
        $this->image = $image;

        return $this;
    }


}
