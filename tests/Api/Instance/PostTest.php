<?php

namespace App\Tests\Api\Instance;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $response = $this->getClient()->request('POST', '/api/instances', [
            'auth_bearer' => $this->getUserToken('user_3@user.test'),
            'body' => json_encode(['name' => 'instance name']),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        $json = $response->toArray();

        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertIsInt($json['id']);
        $this->assertSame('instance name', $json['name']);
        $this->assertSame(3, $json['createdBy']['id']);
        $this->assertIsString($json['createdAt']);
        $this->assertIsString($json['updatedAt']);
    }

    public function testShouldReturnFailedWhenSendDuplicateData(): void
    {
        $response = $this->getClient()->request('POST', '/api/instances', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'body' => json_encode(['name' => 'instance_name_2']),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenSendNoBodyData(): void
    {
        $response = $this->getClient()->request('POST', '/api/instances', [
            'auth_bearer' => $this->getUserToken('user_3@user.test'),
            'body' => json_encode([]),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }
}
