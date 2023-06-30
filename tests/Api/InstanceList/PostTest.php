<?php

namespace App\Tests\Api\InstanceList;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $response = $this->getClient()->request('POST', '/api/instance_lists', [
            'auth_bearer' => $this->getUserToken('user_3@user.test'),
            'body' => json_encode(['name' => 'list name', 'instanceUuid' => 'ffc05eac-0e09-11ee-be56-0242ac120002']),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        $json = $response->toArray();

        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertIsString($json['uuid']);
        $this->assertIsString($json['instance']);
        $this->assertSame('list name', $json['name']);
        $this->assertSame('ffc05d8a-0e09-11ee-be56-0242ac120002', $json['createdBy']['uuid']);
        $this->assertIsString($json['createdAt']);
        $this->assertIsString($json['updatedAt']);
    }

    public function testShouldReturnFailedWhenSendNoBodyData(): void
    {
        $response = $this->getClient()->request('POST', '/api/instance_lists', [
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
