<?php

namespace App\Tests\Api\InstanceList;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $response = $this->getClient()->request('GET', '/api/instance_lists/c904a712-1730-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'headers' => ['Accept' => 'application/json'],
        ]);
        $json = $response->toArray();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('c904a712-1730-11ee-be56-0242ac120002', $json['uuid']);
        $this->assertSame('list name 1', $json['name']);
        $this->assertSame('ffc0574a-0e09-11ee-be56-0242ac120002', $json['createdBy']['uuid']);
        $this->assertIsString($json['createdAt']);
        $this->assertIsString($json['updatedAt']);
    }

    public function testShouldReturnFailedWhenNotFound(): void
    {
        $response = $this->getClient()->request('GET', '/api/instance_lists/c904b18a-1730-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'headers' => ['Accept' => 'application/json'],
        ]);

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenIsNotMine(): void
    {
        $response = $this->getClient()->request('GET', '/api/instance_lists/c904b02c-1730-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'headers' => ['Accept' => 'application/json'],
        ]);

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
