<?php

namespace App\Tests\Api\Instance;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $response = $this->getClient()->request('GET', '/api/instances/ffc05eac-0e09-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'headers' => ['Accept' => 'application/json'],
        ]);
        $json = $response->toArray();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('ffc05eac-0e09-11ee-be56-0242ac120002', $json['uuid']);
        $this->assertSame('instance_name_1', $json['name']);
        $this->assertSame('ffc0574a-0e09-11ee-be56-0242ac120002', $json['createdBy']['uuid']);
        $this->assertIsString($json['createdAt']);
        $this->assertIsString($json['updatedAt']);
    }

    public function testShouldReturnFailedWhenNotFound(): void
    {
        $response = $this->getClient()->request('GET', '/api/instances/04c09400-e396-4eec-808d-339200e588a2', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'headers' => ['Accept' => 'application/json'],
        ]);

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenIsNotMine(): void
    {
        $response = $this->getClient()->request('GET', '/api/instances/ffc05fc4-0e09-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'headers' => ['Accept' => 'application/json'],
        ]);

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
