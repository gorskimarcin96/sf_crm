<?php

namespace App\ApiPlatform\DTO\InstanceList\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class Input
{
    #[Assert\NotBlank]
    public string $name = '';

    #[Assert\NotBlank]
    public string $instanceUuid = '';
}
