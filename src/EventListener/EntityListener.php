<?php

namespace App\EventListener;

use App\Entity\CreatedByInterface;
use App\Entity\User;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

readonly class EntityListener
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private UserPasswordHasherInterface $encoder
    ) {
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof CreatedByInterface) {
            $this->setCreatedBy($entity);
        }

        if ($entity instanceof User) {
            $this->setPassword($entity);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof User) {
            $this->setPassword($entity);
        }
    }

    private function setCreatedBy(CreatedByInterface $createdBy): void
    {
        /** @var User|null $user */
        $user = $this->tokenStorage->getToken()?->getUser();

        if ($user instanceof User) {
            $createdBy->setCreatedBy($user);
        }
    }

    private function setPassword(User $user): void
    {
        if ($user->getPlainPassword()) {
            $user->setPassword($this->encoder->hashPassword($user, $user->getPlainPassword()));
        }
    }
}
