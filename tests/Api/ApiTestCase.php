<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;

abstract class ApiTestCase extends \ApiPlatform\Symfony\Bundle\Test\ApiTestCase
{
    use ReloadDatabaseTrait;

    public function getClient(): Client
    {
        return self::createClient();
    }

    public function getUserToken(string $email): string
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getClient()->getContainer()?->get(UserRepository::class);
        /** @var JWTManager $JWTManager */
        $JWTManager = $this->getClient()->getContainer()?->get('lexik_jwt_authentication.jwt_manager');

        return $JWTManager->create($userRepository->findOneByEmail($email) ?? throw new EntityNotFoundException());
    }
}
