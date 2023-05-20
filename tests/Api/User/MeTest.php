<?php

namespace App\Tests\Api\User;

use App\Tests\Api\ApiTestCase;

class MeTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $client = self::createClient();
        $response = $client->request('GET', '/api/user/me', ['auth_bearer' => $this->getUserToken()]);
        $json = $response->toArray();

        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('id', $json);
        $this->assertArrayHasKey('email', $json);
    }
}
