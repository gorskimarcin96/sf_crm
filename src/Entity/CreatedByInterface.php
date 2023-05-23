<?php

namespace App\Entity;

interface CreatedByInterface
{
    public function getCreatedBy(): User;

    public function setCreatedBy(User $createdBy): self;
}
