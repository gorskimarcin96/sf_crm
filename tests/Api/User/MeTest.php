<?php

namespace App\Tests\Api\User;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class MeTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $response = $this->getClient()->request('GET', '/api/users/me', [
            'headers' => ['Accept' => 'application/json'],
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
        ]);

        $json = $response->toArray();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('uuid', $json);
        $this->assertArrayHasKey('email', $json);
        $this->assertArrayHasKey('createdAt', $json);
        $this->assertArrayHasKey('updatedAt', $json);
    }
}
