<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\ApiPlatform\DTO\Instance\Model\Input;
use App\ApiPlatform\DTO\Instance\Processor\Processor;
use App\Entity\Model\CreatedAtInterface;
use App\Entity\Model\CreatedByInterface;
use App\Entity\Model\UpdatedAtInterface;
use App\Repository\InstanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: InstanceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['instance:read']],
    input: Input::class,
    processor: Processor::class
)]
class Instance implements CreatedAtInterface, UpdatedAtInterface, CreatedByInterface, \Stringable
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['instance:read'])]
    private Uuid $uuid;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['instance:read'])]
    private string $name;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'created_by_uuid', referencedColumnName: 'uuid', nullable: false)]
    #[Groups(['instance:read'])]
    private User $createdBy;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['instance:read'])]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['instance:read'])]
    private \DateTimeInterface $updatedAt;

    /** @var Collection<int, InstanceList> */
    #[ORM\OneToMany(mappedBy: 'instance', targetEntity: InstanceList::class)]
    private Collection $instanceLists;

    public function __construct()
    {
        $this->uuid = Uuid::v1();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->instanceLists = new ArrayCollection();
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

    /**
     * @return Collection<int, InstanceList>
     */
    public function getInstanceLists(): Collection
    {
        return $this->instanceLists;
    }

    public function addInstanceList(InstanceList $instanceList): self
    {
        if (!$this->instanceLists->contains($instanceList)) {
            $this->instanceLists->add($instanceList);
            $instanceList->setInstance($this);
        }

        return $this;
    }
}
