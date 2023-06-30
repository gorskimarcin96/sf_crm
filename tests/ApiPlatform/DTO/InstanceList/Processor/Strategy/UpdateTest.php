<?php

namespace App\Tests\ApiPlatform\DTO\InstanceList\Processor\Strategy;

use App\ApiPlatform\DTO\InstanceList\Model\Input;
use App\ApiPlatform\DTO\InstanceList\Processor\Strategy\ProcessorStrategyInterface;
use App\ApiPlatform\DTO\InstanceList\Processor\Strategy\Update;
use App\Entity\InstanceList;
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
        $input->instanceUuid = 'ffc05eac-0e09-11ee-be56-0242ac120002';
        $result = $this->processorStrategy->execute($input, 'c904a712-1730-11ee-be56-0242ac120002');

        $this->assertInstanceOf(InstanceList::class, $result);
    }

    public function testExecuteFailedWhenGiveWrongParameter(): void
    {
        $this->expectException(\LogicException::class);

        $this->processorStrategy->execute(new InstanceList());
    }
}
