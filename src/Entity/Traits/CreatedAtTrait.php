<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait CreatedAtTrait
{
    #[ORM\Column(type: 'datetime')]
    #[Groups(['default'])]
    private \DateTime $createdAt;

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt ?? new \DateTime();
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PrePersist()]
    public function updateCreatedAt(): void
    {
        // @phpstan-ignore-next-line
        if (null === $this->getId()) {
            $this->setCreatedAt(new \DateTime());
        }
    }
}
