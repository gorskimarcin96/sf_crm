<?php

namespace App\Tests\EventListener;

use App\Entity\Instance;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EntityListenerTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private TokenStorageInterface $tokenStorage;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $this->entityManager = $entityManager;
        /** @var TokenStorageInterface $tokenStorage */
        $tokenStorage = self::getContainer()->get(TokenStorageInterface::class);
        $this->tokenStorage = $tokenStorage;
    }

    public function testSetCreatedBySuccessfullyWhenPrePersist(): void
    {
        $user = $this->entityManager->getRepository(User::class)->find('ffc05d8a-0e09-11ee-be56-0242ac120002');
        $this->tokenStorage->setToken(new JWTUserToken([], $user, null, 'api'));

        $entity = new Instance();
        $entity->setName('pre persist');

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->assertSame($user, $entity->getCreatedBy());
    }

    public function testSetPasswordSuccessfullyWhenPrePersist(): void
    {
        $user = new User();
        $user->setEmail('pre@persist');
        $user->setPlainPassword('test pre persist');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->assertIsString($user->getPassword());
    }

    public function testSetPasswordSuccessfullyWhenPreUpdate(): void
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy([]);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->assertIsString($user->getPassword());
    }
}
