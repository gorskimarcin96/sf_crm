<?php

namespace App\ApiPlatform\DTO\InstanceList\Processor\Strategy;

use App\ApiPlatform\DTO\InstanceList\Model\Input;
use App\Entity\InstanceList;

interface ProcessorStrategyInterface
{
    public function execute(Input|InstanceList $input, ?string $uuid = null): ?InstanceList;
}
