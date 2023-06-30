<?php

namespace App\ApiPlatform\DTO\Instance\Processor\Strategy;

use App\ApiPlatform\DTO\Instance\Model\Input;
use App\Entity\Instance;

interface ProcessorStrategyInterface
{
    public function execute(Input|Instance $input, ?string $uuid = null): ?Instance;
}
