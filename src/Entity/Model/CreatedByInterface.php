<?php

namespace App\Entity\Model;

use App\Entity\User;

interface CreatedByInterface
{
    public function getCreatedBy(): User;

    public function setCreatedBy(User $createdBy): self;
}
