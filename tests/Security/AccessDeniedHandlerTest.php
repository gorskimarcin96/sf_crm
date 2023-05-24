<?php

namespace App\Tests\Security;

use App\Security\AccessDeniedHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedHandlerTest extends KernelTestCase
{
    private AccessDeniedHandler $accessDeniedHandler;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var AccessDeniedHandler $accessDeniedHandler */
        $accessDeniedHandler = self::getContainer()->get(AccessDeniedHandler::class);
        $this->accessDeniedHandler = $accessDeniedHandler;
    }

    public function testHandle(): void
    {
        $request = new Request();
        $request->setSession(new Session(new MockArraySessionStorage()));
        $result = $this->accessDeniedHandler->handle($request, new AccessDeniedException());

        $this->assertInstanceOf(Response::class, $result);
    }
}
