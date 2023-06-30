<?php

namespace App\ApiPlatform\DTO\Instance\Processor\Strategy;

use App\ApiPlatform\DTO\Instance\Model\Input;
use App\Entity\Instance;
use App\Repository\InstanceRepository;

readonly class Delete implements ProcessorStrategyInterface
{
    public function __construct(private InstanceRepository $repository)
    {
    }

    public function execute(Input|Instance $input, string $uuid = null): null
    {
        if (!$input instanceof Instance) {
            throw new \LogicException();
        }

        $this->repository->remove($input, true);

        return null;
    }
}
