<?php

namespace App\Controller\Api\User;

use App\ApiPlatform\DTO\User\Input;
use App\ApiPlatform\Validator;
use App\Controller\Api\Exception\UserUniqueException;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly Validator $validator,
        private readonly UserPasswordHasherInterface $encoder,
    ) {
    }

    /**
     * @throws UserUniqueException
     */
    public function __invoke(Input $input): User
    {
        $this->validator->validate($input);

        if ($this->repository->isExistsByEmail($input->email)) {
            throw new UserUniqueException($input->email);
        }

        $entity = new User();
        $entity->setEmail($input->email);
        $entity->setPassword($this->encoder->hashPassword($entity, $input->password));
        $this->repository->save($entity, true);

        return $entity;
    }
}
