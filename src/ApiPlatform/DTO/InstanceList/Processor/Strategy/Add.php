<?php

namespace App\ApiPlatform\DTO\InstanceList\Processor\Strategy;

use App\ApiPlatform\DTO\InstanceList\Model\Input;
use App\ApiPlatform\Service\Validator;
use App\Entity\InstanceList;
use App\Repository\InstanceListRepository;
use App\Repository\InstanceRepository;
use Doctrine\ORM\EntityNotFoundException;

readonly class Add implements ProcessorStrategyInterface
{
    public function __construct(
        private InstanceListRepository $instanceListRepository,
        private InstanceRepository $instanceRepository,
        private Validator $validator
    ) {
    }

    public function execute(Input|InstanceList $input, ?string $uuid = null): InstanceList
    {
        if (!$input instanceof Input) {
            throw new \LogicException();
        }

        $this->validator->validate($input);
        $instance = $this->instanceRepository->find($input->instanceUuid) ?? throw new EntityNotFoundException();

        $entity = new InstanceList();
        $entity->setName($input->name);
        $entity->setInstance($instance);

        $this->instanceListRepository->save($entity, true);

        return $entity;
    }
}
