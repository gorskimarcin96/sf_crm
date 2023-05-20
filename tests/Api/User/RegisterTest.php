<?php

namespace App\Tests\Api\User;

use App\Tests\Api\ApiTestCase;

class RegisterTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $client = self::createClient();
        $response = $client->request('POST', '/api/user/register', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'test@user.test',
                'password' => 'password',
            ],
        ]);
        $json = $response->toArray();

        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('id', $json);
        $this->assertArrayHasKey('email', $json);
    }

    public function testShouldReturnFailedWhenSendEmptyData(): void
    {
        $client = self::createClient();
        $client->request('POST', '/api/user/register', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [],
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testShouldReturnFailedWhenEmailIsNotValid(): void
    {
        $client = self::createClient();
        $client->request('POST', '/api/user/register', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'user',
                'password' => 'password',
            ],
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testShouldReturnFailedWhenEmailIsExists(): void
    {
        $client = self::createClient();
        $client->request('POST', '/api/user/register', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'user@user.test',
                'password' => 'password',
            ],
        ]);

        $this->assertResponseStatusCodeSame(400);
    }
}
