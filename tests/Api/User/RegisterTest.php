<?php

namespace App\Tests\Api\User;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegisterTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $response = $this->getClient()->request('POST', '/api/users/register', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'test@user.test',
                'password' => 'password',
            ],
        ]);
        $json = $response->toArray();

        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertArrayHasKey('id', $json);
        $this->assertArrayHasKey('email', $json);
    }

    public function testShouldReturnFailedWhenSendEmptyData(): void
    {
        $response = $this->getClient()->request('POST', '/api/users/register', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [],
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenEmailIsNotValid(): void
    {
        $response = $this->getClient()->request('POST', '/api/users/register', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'user',
                'password' => 'password',
            ],
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenEmailIsExists(): void
    {
        $response = $this->getClient()->request('POST', '/api/users/register', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'user_1@user.test',
                'password' => 'password',
            ],
        ]);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
