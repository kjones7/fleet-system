<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_USER')",
            paginationItemsPerPage: 30
        ),
        new Post(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Get(
            security: "is_granted('ROLE_USER')"
        ),
        new Put(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        ),
    ],
    normalizationContext: [
        'groups' => ['vehicle:read']
    ],
    denormalizationContext: [
        'groups' => ['vehicle:write']
    ]
)]
#[ORM\Entity]
#[UniqueEntity('vin')]
class Vehicle
{
    #[ApiProperty(identifier: true)]
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ApiProperty(description: 'Vehicle Identification Number')]
    #[Assert\NotBlank]
    #[Assert\Length(exactly: 17)]
    #[Assert\Regex(
        pattern: '/^[A-HJ-NPR-Z0-9]{17}$/',
        message: 'VIN must be 17 characters and can only contain capital letters (except I, O, Q) and numbers'
    )]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    #[ORM\Column(length: 17, unique: true)]
    public string $vin;

    #[ApiProperty(description: 'Vehicle make (manufacturer)')]
    #[Assert\NotBlank]
    #[ApiFilter(SearchFilter::class, strategy: 'ipartial')]
    #[ORM\Column(length: 50)]
    public string $make;

    #[ApiProperty(description: 'Vehicle model')]
    #[Assert\NotBlank]
    #[ApiFilter(SearchFilter::class, strategy: 'ipartial')]
    #[ORM\Column(length: 50)]
    public string $model;

    #[ApiProperty(description: 'Vehicle year')]
    #[Assert\NotBlank]
    #[Assert\Range(min: 1900, max: 2100)]
    #[ORM\Column(type: 'integer')]
    public int $year;

    #[ApiProperty(description: 'License plate number')]
    #[Assert\NotBlank]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    #[ORM\Column(length: 20)]
    public string $licensePlate;

    #[ApiProperty(description: 'Current odometer reading')]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[ORM\Column(type: 'decimal', precision: 10, scale: 1)]
    public float $odometer;

    #[ApiProperty(description: 'Vehicle status')]
    #[Assert\NotBlank]
    #[Assert\Choice(['active', 'maintenance', 'retired'])]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    #[ORM\Column(length: 20)]
    public string $status = 'active';

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
