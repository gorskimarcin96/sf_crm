<?php

namespace App\ApiPlatform\Service;

use ApiPlatform\Symfony\Validator\Exception\ValidationException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class Validator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * @param Constraint|Constraint[]|null                       $constraints
     * @param string|string[]|GroupSequence|GroupSequence[]|null $groups
     */
    public function validate(
        object $object,
        Constraint|array $constraints = null,
        string|GroupSequence|array $groups = null
    ): void {
        /** @var ConstraintViolationList $errors */
        $errors = $this->validator->validate($object, $constraints, $groups);

        if (0 !== $errors->count()) {
            throw new ValidationException($errors);
        }
    }
}
