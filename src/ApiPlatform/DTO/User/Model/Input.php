<?php

namespace App\ApiPlatform\DTO\User\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class Input
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email = '';

    #[Assert\NotBlank]
    public string $password = '';
}
