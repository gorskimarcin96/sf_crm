<?php

namespace App\ApiPlatform\DTO\InstanceList\Processor\Strategy;

use App\ApiPlatform\DTO\InstanceList\Model\Input;
use App\ApiPlatform\Service\Validator;
use App\Entity\Instance;
use App\Entity\InstanceList;
use App\Repository\InstanceListRepository;
use App\Repository\InstanceRepository;

readonly class Update implements ProcessorStrategyInterface
{
    public function __construct(
        private InstanceListRepository $repository,
        private Validator $validator,
        private InstanceRepository $instanceRepository
    ) {
    }

    public function execute(Input|InstanceList $input, string $uuid = null): InstanceList
    {
        if (!$input instanceof Input) {
            throw new \LogicException();
        }

        $this->validator->validate($input);

        /** @var Instance $instance */
        $instance = $this->instanceRepository->find($input->instanceUuid);
        /** @var InstanceList $entity */
        $entity = $this->repository->find($uuid);
        $entity->setInstance($instance);
        $entity->setName($input->name);

        $this->repository->save($entity, true);

        return $entity;
    }
}
