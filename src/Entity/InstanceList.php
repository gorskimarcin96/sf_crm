<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\ApiPlatform\DTO\InstanceList\Model\Input;
use App\ApiPlatform\DTO\InstanceList\Processor\Processor;
use App\Entity\Model\CreatedAtInterface;
use App\Entity\Model\CreatedByInterface;
use App\Entity\Model\UpdatedAtInterface;
use App\Repository\InstanceListRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: InstanceListRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['instance_list:read']],
    input: Input::class,
    processor: Processor::class
)]
class InstanceList implements CreatedAtInterface, UpdatedAtInterface, CreatedByInterface, \Stringable
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['instance_list:read'])]
    private Uuid $uuid;

    #[ORM\ManyToOne(inversedBy: 'instanceLists')]
    #[Groups(['instance_list:read'])]
    #[ORM\JoinColumn(name: 'instance_uuid', referencedColumnName: 'uuid', nullable: false, onDelete: 'CASCADE')]
    private Instance $instance;

    #[ORM\Column(length: 255)]
    #[Groups(['instance_list:read'])]
    private string $name;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'created_by_uuid', referencedColumnName: 'uuid', nullable: false)]
    #[Groups(['instance_list:read'])]
    private User $createdBy;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['instance_list:read'])]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['instance_list:read'])]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->uuid = Uuid::v1();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function __toString(): string
    {
        return $this->uuid.'#'.$this->name;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = Uuid::fromString($uuid);

        return $this;
    }

    public function getInstance(): Instance
    {
        return $this->instance;
    }

    public function setInstance(Instance $instance): self
    {
        $this->instance = $instance;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt ?? new \DateTime();
    }

    public function setCreatedAt(\DateTimeInterface $dateTime): self
    {
        $this->createdAt = $dateTime;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt ?? new \DateTime();
    }

    public function setUpdatedAt(\DateTimeInterface $dateTime): self
    {
        $this->updatedAt = $dateTime;

        return $this;
    }
}
