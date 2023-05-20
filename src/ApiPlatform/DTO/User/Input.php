<?php

namespace App\ApiPlatform\DTO\User;

use Symfony\Component\Validator\Constraints as Assert;

class Input
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email = '';

    #[Assert\NotBlank]
    public string $password = '';
}
