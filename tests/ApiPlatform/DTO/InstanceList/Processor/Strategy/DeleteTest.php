<?php

namespace App\Tests\ApiPlatform\DTO\InstanceList\Processor\Strategy;

use App\ApiPlatform\DTO\InstanceList\Model\Input;
use App\ApiPlatform\DTO\InstanceList\Processor\Strategy\Delete;
use App\ApiPlatform\DTO\InstanceList\Processor\Strategy\ProcessorStrategyInterface;
use App\Entity\InstanceList;
use App\Repository\InstanceListRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DeleteTest extends KernelTestCase
{
    private ProcessorStrategyInterface $processorStrategy;
    private InstanceListRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Delete $processorStrategy */
        $processorStrategy = self::getContainer()->get(Delete::class);
        $this->processorStrategy = $processorStrategy;
        /** @var InstanceListRepository $repository */
        $repository = self::getContainer()->get(InstanceListRepository::class);
        $this->repository = $repository;
    }

    public function testExecuteSuccessfully(): void
    {
        /** @var InstanceList $instanceList */
        $instanceList = $this->repository->findOneBy([]);
        $result = $this->processorStrategy->execute($instanceList);

        $this->assertNull($result);
    }

    public function testExecuteFailedWhenGiveWrongParameter(): void
    {
        $this->expectException(\LogicException::class);

        $this->processorStrategy->execute(new Input());
    }
}
