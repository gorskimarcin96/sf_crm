<?php

namespace App\ApiPlatform\Extension;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\CreatedByInterface;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final readonly class CreatedByExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    /**
     * @param array<string,string> $context
     */
    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * @param array<string,string> $identifiers
     * @param array<string,string> $context
     */
    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        Operation $operation = null,
        array $context = []
    ): void {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        $reflectionClass = new \ReflectionClass(new $resourceClass());
        /** @var User $user */
        $user = $this->tokenStorage->getToken()?->getUser();
        $userUuid = $user->getUuid();

        if ($reflectionClass->implementsInterface(CreatedByInterface::class)) {
            $queryBuilder->andWhere(sprintf('%s.createdBy = :current_user', $queryBuilder->getRootAliases()[0]));
            $queryBuilder->setParameter('current_user', $userUuid);
        }
    }
}
