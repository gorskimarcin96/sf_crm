<?php

namespace App\EventListener;

use App\Entity\Model\CreatedAtInterface;
use App\Entity\Model\CreatedByInterface;
use App\Entity\Model\UpdatedAtInterface;
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

        if ($entity instanceof CreatedAtInterface) {
            $this->setCreatedAt($entity);
        }

        if ($entity instanceof UpdatedAtInterface) {
            $this->setUpdatedAt($entity);
        }

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

        if ($entity instanceof UpdatedAtInterface) {
            $this->setUpdatedAt($entity);
        }

        if ($entity instanceof User) {
            $this->setPassword($entity);
        }
    }

    private function setCreatedAt(CreatedAtInterface $entity): void
    {
        $entity->setCreatedAt(new \DateTime());
    }

    private function setUpdatedAt(UpdatedAtInterface $entity): void
    {
        $entity->setUpdatedAt(new \DateTime());
    }

    private function setCreatedBy(CreatedByInterface $entity): void
    {
        /** @var User|null $user */
        $user = $this->tokenStorage->getToken()?->getUser();

        if ($user instanceof User) {
            $entity->setCreatedBy($user);
        }
    }

    private function setPassword(User $entity): void
    {
        if ($entity->getPlainPassword()) {
            $entity->setPassword($this->encoder->hashPassword($entity, $entity->getPlainPassword()));
        }
    }
}
