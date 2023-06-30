<?php

namespace App\ApiPlatform\DTO\Instance\Processor\Strategy;

use App\ApiPlatform\DTO\Instance\Model\Input;
use App\ApiPlatform\Exception\InstanceUniqueException;
use App\ApiPlatform\Service\Validator;
use App\Entity\Instance;
use App\Repository\InstanceRepository;

readonly class Add implements ProcessorStrategyInterface
{
    public function __construct(private InstanceRepository $repository, private Validator $validator)
    {
    }

    public function execute(Input|Instance $input, ?string $uuid = null): Instance
    {
        if (!$input instanceof Input) {
            throw new \LogicException();
        }

        $this->validator->validate($input);

        if ($this->repository->isExistsByName($input->name)) {
            throw new InstanceUniqueException($input->name);
        }

        $entity = new Instance();
        $entity->setName($input->name);

        $this->repository->save($entity, true);

        return $entity;
    }
}
