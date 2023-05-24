<?php

namespace App\Tests\ApiPlatform\DTO\Instance\Processor\Strategy;

use App\ApiPlatform\DTO\Instance\Model\Input;
use App\ApiPlatform\DTO\Instance\Processor\Strategy\Delete;
use App\ApiPlatform\DTO\Instance\Processor\Strategy\ProcessorStrategyInterface;
use App\Entity\Instance;
use App\Repository\InstanceRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DeleteTest extends KernelTestCase
{
    private ProcessorStrategyInterface $processorStrategy;
    private InstanceRepository $instanceRepository;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Delete $processorStrategy */
        $processorStrategy = self::getContainer()->get(Delete::class);
        $this->processorStrategy = $processorStrategy;
        /** @var InstanceRepository $instanceRepository */
        $instanceRepository = self::getContainer()->get(InstanceRepository::class);
        $this->instanceRepository = $instanceRepository;
    }

    public function testExecuteSuccessfully(): void
    {
        /** @var Instance $instance */
        $instance = $this->instanceRepository->findOneBy([]);
        $result = $this->processorStrategy->execute($instance);

        $this->assertNull($result);
    }

    public function testExecuteFailedWhenGiveWrongParameter(): void
    {
        $this->expectException(\LogicException::class);

        $this->processorStrategy->execute(new Input());
    }
}
