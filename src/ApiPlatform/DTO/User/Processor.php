<?php

namespace App\ApiPlatform\DTO\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiPlatform\DTO\User\Model\Input;
use App\ApiPlatform\Exception\UserUniqueException;
use App\ApiPlatform\Service\Validator;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class Processor implements ProcessorInterface
{
    public function __construct(
        private Validator $validator,
        private UserRepository $repository,
        private UserPasswordHasherInterface $encoder,
    ) {
    }

    /**
     * @param Input                 $data
     * @param array<string, string> $uriVariables
     * @param array<string, string> $context
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        $this->validator->validate($data);

        if ($this->repository->isExistsByEmail($data->email)) {
            throw new UserUniqueException($data->email);
        }

        $entity = new User();
        $entity->setEmail($data->email);
        $entity->setPassword($this->encoder->hashPassword($entity, $data->password));

        $this->repository->save($entity, true);

        return $entity;
    }
}
