<?php

namespace App\Tests\ApiPlatform\DTO\Instance\Processor\Strategy;

use App\ApiPlatform\DTO\Instance\Model\Input;
use App\ApiPlatform\DTO\Instance\Processor\Strategy\ProcessorStrategyInterface;
use App\ApiPlatform\DTO\Instance\Processor\Strategy\Update;
use App\Entity\Instance;
use App\Tests\Api\ApiTestCase;

class UpdateTest extends ApiTestCase
{
    private ProcessorStrategyInterface $processorStrategy;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Update $processorStrategy */
        $processorStrategy = self::getContainer()->get(Update::class);
        $this->processorStrategy = $processorStrategy;
    }

    public function testExecuteSuccessfully(): void
    {
        $input = new Input();
        $input->name = 'name';
        $result = $this->processorStrategy->execute($input, 1);

        $this->assertInstanceOf(Instance::class, $result);
    }

    public function testExecuteFailedWhenGiveWrongParameter(): void
    {
        $this->expectException(\LogicException::class);

        $this->processorStrategy->execute(new Instance());
    }
}
