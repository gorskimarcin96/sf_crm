<?php

namespace App\Tests\Api;

use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

abstract class ApiTestCase extends \ApiPlatform\Symfony\Bundle\Test\ApiTestCase
{
    use ReloadDatabaseTrait;

    public function getUserToken(): string
    {
        $client = self::createClient();
        $response = $client->request('POST', '/api/authentication', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'user@user.test',
                'password' => 'password',
            ],
        ]);

        return $response->toArray()['token'];
    }
}
