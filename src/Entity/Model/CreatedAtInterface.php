<?php

namespace App\Entity\Model;

interface CreatedAtInterface
{
    public function getCreatedAt(): \DateTimeInterface;

    public function setCreatedAt(\DateTimeInterface $dateTime): self;
}
