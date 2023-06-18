<?php

namespace App\Tests\ApiPlatform\DTO\Instance\Processor\Strategy;

use App\ApiPlatform\DTO\Instance\Model\Input;
use App\ApiPlatform\DTO\Instance\Processor\Strategy\Add;
use App\ApiPlatform\DTO\Instance\Processor\Strategy\ProcessorStrategyInterface;
use App\Entity\Instance;
use App\Repository\UserRepository;
use App\Tests\Api\ApiTestCase;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AddTest extends ApiTestCase
{
    private ProcessorStrategyInterface $processorStrategy;
    private UserRepository $userRepository;
    private TokenStorageInterface $tokenStorage;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Add $processorStrategy */
        $processorStrategy = self::getContainer()->get(Add::class);
        $this->processorStrategy = $processorStrategy;
        /** @var TokenStorageInterface $tokenStorage */
        $tokenStorage = self::getContainer()->get(TokenStorageInterface::class);
        $this->tokenStorage = $tokenStorage;
        /** @var UserRepository $userRepository */
        $userRepository = self::getContainer()->get(UserRepository::class);
        $this->userRepository = $userRepository;
    }

    public function testExecuteSuccessfully(): void
    {
        $user = $this->userRepository->find('ffc05d8a-0e09-11ee-be56-0242ac120002');
        $this->tokenStorage->setToken(new JWTUserToken([], $user, null, 'api'));

        $input = new Input();
        $input->name = 'name';
        $result = $this->processorStrategy->execute($input);

        $this->assertInstanceOf(Instance::class, $result);
    }

    public function testExecuteFailedWhenGiveWrongParameter(): void
    {
        $this->expectException(\LogicException::class);

        $this->processorStrategy->execute(new Instance());
    }
}
