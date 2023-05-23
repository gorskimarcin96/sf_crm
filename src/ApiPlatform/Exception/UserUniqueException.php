<?php

namespace App\ApiPlatform\Exception;

class UserUniqueException extends UniqueException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('User is exists with address email "%s".', $email));
    }
}
