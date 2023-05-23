<?php

namespace App\EventListener;

use App\Entity\CreatedByInterface;
use App\Entity\User;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

readonly class EntityListener
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        /** @var User|null $user */
        $user = $this->tokenStorage->getToken()?->getUser();
        $entity = $args->getObject();

        if ($user && $entity instanceof CreatedByInterface) {
            $entity->setCreatedBy($user);
        }
    }
}
