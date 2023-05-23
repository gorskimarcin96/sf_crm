<?php

namespace App\ApiPlatform\Exception;

class InstanceUniqueException extends UniqueException
{
    public function __construct(string $name)
    {
        parent::__construct(sprintf('Instance is exists with name "%s".', $name));
    }
}
