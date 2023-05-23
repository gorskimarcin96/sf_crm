<?php

namespace App\ApiPlatform\DTO\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/** @implements ProviderInterface<User> */
final readonly class Provider implements ProviderInterface
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    /**
     * @param array<string, string> $uriVariables
     * @param array<string, string> $context
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): User
    {
        /** @var User $entity */
        $entity = $this->tokenStorage->getToken()?->getUser();

        return $entity;
    }
}
