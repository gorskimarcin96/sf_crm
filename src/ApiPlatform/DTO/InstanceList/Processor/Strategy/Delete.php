<?php

namespace App\ApiPlatform\DTO\InstanceList\Processor\Strategy;

use App\ApiPlatform\DTO\InstanceList\Model\Input;
use App\Entity\InstanceList;
use App\Repository\InstanceListRepository;

readonly class Delete implements ProcessorStrategyInterface
{
    public function __construct(private InstanceListRepository $repository)
    {
    }

    public function execute(Input|InstanceList $input, ?string $uuid = null): null
    {
        if (!$input instanceof InstanceList) {
            throw new \LogicException();
        }

        $this->repository->remove($input, true);

        return null;
    }
}
