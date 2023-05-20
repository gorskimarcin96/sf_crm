<?php

namespace App\Tests\Api\Authentication;

use App\Tests\Api\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class AuthenticationTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testShouldReturnSuccessfully(): void
    {
        $client = self::createClient();
        $response = $client->request('POST', '/api/authentication', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'user@user.test',
                'password' => 'password',
            ],
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $json);
        $client->request('GET', '/api/user/me', ['auth_bearer' => $json['token']]);

        $this->assertResponseIsSuccessful();
    }

    public function testShouldReturnFailedWhenUseWrongToken(): void
    {
        $client = self::createClient();
        $client->request('GET', '/api/user/me', ['auth_bearer' => 'wrong_token']);

        $this->assertResponseStatusCodeSame(401);
    }

    public function testShouldReturnFailedWhenNotUseAuthBearer(): void
    {
        $client = self::createClient();
        $client->request('GET', '/api/user/me');

        $this->assertResponseStatusCodeSame(401);
    }
}
