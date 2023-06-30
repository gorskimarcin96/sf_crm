<?php

namespace App\Tests\Api\InstanceList;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetCollectionTest extends ApiTestCase
{
    public function testShouldReturnSuccessfully(): void
    {
        $response = $this->getClient()->request('GET', '/api/instance_lists', [
            'auth_bearer' => $this->getUserToken('user_1@user.test'),
            'headers' => ['Accept' => 'application/json'],
        ]);
        $json = $response->toArray();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertCount(3, $json);
    }
}
