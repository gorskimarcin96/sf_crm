<?php

namespace App\Tests\ApiPlatform\Service;

use ApiPlatform\Symfony\Validator\Exception\ValidationException;
use App\ApiPlatform\DTO\Instance\Model\Input;
use App\ApiPlatform\Service\Validator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ValidatorTest extends KernelTestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Validator $validator */
        $validator = self::getContainer()->get(Validator::class);
        $this->validator = $validator;
    }

    public function testValidateSuccessfullyWhenIsValid(): void
    {
        $object = new Input();
        $object->name = 'test';
        $this->validator->validate($object);

        $this->assertTrue(true);
    }

    public function testValidateFailedWhenIsNotValid(): void
    {
        $this->expectException(ValidationException::class);

        $this->validator->validate(new Input());
    }
}
