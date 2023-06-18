<?php

namespace App\ApiPlatform\DTO\Instance\Processor;

use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiPlatform\DTO\Instance\Model\Input;
use App\ApiPlatform\DTO\Instance\Processor\Strategy\Add;
use App\ApiPlatform\DTO\Instance\Processor\Strategy\Delete;
use App\ApiPlatform\DTO\Instance\Processor\Strategy\Update;
use App\Entity\Instance;

readonly class Processor implements ProcessorInterface
{
    public function __construct(private Add $add, private Update $update, private Delete $delete)
    {
    }

    /**
     * @param Input|Instance        $data
     * @param array<string, string> $uriVariables
     * @param array<string, string> $context
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): Instance|null {
        /** @var HttpOperation $operation */
        $operation = $context['operation'];

        return match ($operation->getMethod()) {
            'POST' => $this->add->execute($data),
            'PATCH', 'PUT' => $this->update->execute($data, $uriVariables['uuid']),
            'DELETE' => $this->delete->execute($data),
            default => throw new \LogicException(),
        };
    }
}
