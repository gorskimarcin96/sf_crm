<?php

namespace App\Tests\Api\Instance;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PatchTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $response = $this->getClient()->request('PATCH', '/api/instances/ffc05eac-0e09-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'body' => json_encode(['name' => 'instance name updated']),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/merge-patch+json',
            ],
        ]);
        $json = $response->toArray();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsString($json['uuid']);
        $this->assertSame('instance name updated', $json['name']);
        $this->assertSame('ffc0574a-0e09-11ee-be56-0242ac120002', $json['createdBy']['uuid']);
        $this->assertIsString($json['createdAt']);
        $this->assertIsString($json['updatedAt']);
    }

    public function testShouldReturnFailedWhenSendDuplicateData(): void
    {
        $response = $this->getClient()->request('PATCH', '/api/instances/ffc05eac-0e09-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'body' => json_encode(['name' => 'instance_name_2']),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/merge-patch+json',
            ],
        ]);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenNotFound(): void
    {
        $response = $this->getClient()->request('PATCH', '/api/instances/04c09400-e396-4eec-808d-339200e588a2', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'body' => json_encode(['name' => 'instance name updated']),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/merge-patch+json',
            ],
        ]);

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenIsNotMine(): void
    {
        $response = $this->getClient()->request('PATCH', '/api/instances/ffc05fc4-0e09-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'body' => json_encode(['name' => 'instance name updated']),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/merge-patch+json',
            ],
        ]);

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
