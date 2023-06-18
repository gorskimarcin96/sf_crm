<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\ApiPlatform\DTO\Instance\Model\Input;
use App\ApiPlatform\DTO\Instance\Processor\Processor;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\CreatedByTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\InstanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: InstanceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['instance:read', 'user:read', 'created_at:read', 'updated_at:read']],
    input: Input::class,
    processor: Processor::class
)]
#[ORM\HasLifecycleCallbacks()]
class Instance implements CreatedByInterface
{
    use CreatedAtTrait;
    use CreatedByTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['instance:read'])]
    private Uuid $uuid;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['instance:read'])]
    private string $name;

    public function __construct()
    {
        $this->uuid = Uuid::v1();
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
