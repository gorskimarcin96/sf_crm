<?php

namespace App\ApiPlatform\Provider\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/** @implements ProviderInterface<User> */
readonly class Me implements ProviderInterface
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
        /** @var User $user */
        $user = $this->tokenStorage->getToken()?->getUser();

        return $user;
    }
}
