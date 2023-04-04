<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Action\CreateMediaObjectAction;
use App\Repository\MediaObjectRepository;
use ArrayObject;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\OpenApi\Model;

#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(),
        new Post(
            controller: CreateMediaObjectAction::class,
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    content: new ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ])
                )
            ),
            validationContext: ['groups' => ['postMediaObject']],
            deserialize: false,
        )
    ],
    normalizationContext: ['groups' => ['normalizeMediaObject']],
)]
#[ORM\Entity(repositoryClass: MediaObjectRepository::class)]
class MediaObject
{
    #[Groups(['normalizeMediaObject'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filepath = null;

    #[Vich\UploadableField(mapping: "media_object", fileNameProperty: "filepath")]
    #[Assert\NotNull(groups: ['postMediaObject'])]
    public ?File $file = null;

    #[ApiProperty]
    #[Groups(['normalizeMediaObject'])]
    public ?string $contentUrl = null;

    #[ORM\ManyToOne(inversedBy: 'mediaObjects')]
    private ?User $uploadedby = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    public function setFilepath(string $filepath): self
    {
        $this->filepath = $filepath;

        return $this;
    }

    public function getUploadedby(): ?User
    {
        return $this->uploadedby;
    }

    public function setUploadedby(?User $uploadedby): self
    {
        $this->uploadedby = $uploadedby;

        return $this;
    }

}
