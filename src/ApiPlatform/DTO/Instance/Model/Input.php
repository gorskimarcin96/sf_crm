<?php

namespace App\ApiPlatform\DTO\Instance\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class Input
{
    #[Assert\NotBlank]
    public string $name = '';
}
