<?php

namespace App\ApiPlatform\DTO\InstanceList\Processor;

use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiPlatform\DTO\InstanceList\Model\Input;
use App\ApiPlatform\DTO\InstanceList\Processor\Strategy\Add;
use App\ApiPlatform\DTO\InstanceList\Processor\Strategy\Delete;
use App\ApiPlatform\DTO\InstanceList\Processor\Strategy\Update;
use App\Entity\InstanceList;

readonly class Processor implements ProcessorInterface
{
    public function __construct(private Add $add, private Update $update, private Delete $delete)
    {
    }

    /**
     * @param Input|InstanceList    $data
     * @param array<string, string> $uriVariables
     * @param array<string, string> $context
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): InstanceList|null {
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
