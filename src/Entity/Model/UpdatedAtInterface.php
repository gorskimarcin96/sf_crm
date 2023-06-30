<?php

namespace App\Entity\Model;

interface UpdatedAtInterface
{
    public function getUpdatedAt(): \DateTimeInterface;

    public function setUpdatedAt(\DateTimeInterface $dateTime): self;
}
