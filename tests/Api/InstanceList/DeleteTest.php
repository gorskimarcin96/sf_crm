<?php

namespace App\Tests\Api\InstanceList;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeleteTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $response = $this->getClient()->request('DELETE', '/api/instance_lists/c904a712-1730-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'headers' => ['Accept' => 'application/json'],
        ]);

        $this->assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenNotFound(): void
    {
        $response = $this->getClient()->request('DELETE', '/api/instance_lists/c904b18a-1730-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'headers' => ['Accept' => 'application/json'],
        ]);

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testShouldReturnFailedWhenIsNotMine(): void
    {
        $response = $this->getClient()->request('DELETE', '/api/instance_lists/c904b02c-1730-11ee-be56-0242ac120002', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'headers' => ['Accept' => 'application/json'],
        ]);

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
