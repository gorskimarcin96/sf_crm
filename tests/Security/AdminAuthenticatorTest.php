<?php

namespace App\Tests\Security;

use App\Security\AdminAuthenticator;
use App\Utils\Faker\Invoker;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class AdminAuthenticatorTest extends KernelTestCase
{
    use Invoker;

    private AdminAuthenticator $adminAuthenticator;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var AdminAuthenticator $adminAuthenticator */
        $adminAuthenticator = self::getContainer()->get(AdminAuthenticator::class);
        $this->adminAuthenticator = $adminAuthenticator;
    }

    public function testAuthenticate(): void
    {
        $request = new Request();
        $request->setSession(new Session(new MockArraySessionStorage()));
        $result = $this->adminAuthenticator->authenticate($request);

        $this->assertInstanceOf(Passport::class, $result);
    }

    public function testOnAuthenticationSuccess(): void
    {
        $request = new Request();
        $request->setSession(new Session(new MockArraySessionStorage()));
        $result = $this->adminAuthenticator->onAuthenticationSuccess($request, new JWTUserToken(), 'admin');

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function testGetLoginUrl(): void
    {
        $request = new Request();
        $request->setSession(new Session(new MockArraySessionStorage()));

        $this->assertIsString($this->invokeMethod($this->adminAuthenticator, 'getLoginUrl', [$request]));
    }
}
