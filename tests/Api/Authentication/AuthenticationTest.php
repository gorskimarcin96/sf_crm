<?php

namespace App\Tests\Api\Authentication;

use App\Tests\Api\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testShouldReturnSuccessfully(): void
    {
        $response = $this->getClient()->request('POST', '/api/authentication', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'user_1@user.test',
                'password' => 'password',
            ],
        ]);

        $json = $response->toArray();
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('token', $json);

        $response = $this->getClient()->request('GET', '/api/users/me', ['auth_bearer' => $json['token']]);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenUseWrongToken(): void
    {
        $response = $this->getClient()->request('GET', '/api/users/me', ['auth_bearer' => 'wrong_token']);

        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenNotUseAuthBearer(): void
    {
        $response = $this->getClient()->request('GET', '/api/users/me');

        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
}
