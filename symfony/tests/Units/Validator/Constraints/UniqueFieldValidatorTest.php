<?php

declare(strict_types=1);

namespace App\Tests\Units\Validator\Constraints;

use App\Entity\Astronaut;
use App\Repository\AstronautRepository;
use App\Validator\Constraints\UniqueField;
use App\Validator\Constraints\UniqueFieldValidator;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

final class UniqueFieldValidatorTest extends ConstraintValidatorTestCase
{
    use ProphecyTrait;

    private AstronautRepository|ObjectProphecy $astronautRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->astronautRepository = $this->prophesize(AstronautRepository::class);
        $this->propertyPath = '[name]';
        $this->value = 'toto';
        $this->constraint = new UniqueField(repository: $this->astronautRepository->reveal());

        $this->context = $this->createContext();
        $this->validator = $this->createValidator();
        $this->validator->initialize($this->context);
    }

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new UniqueFieldValidator();
    }

    public function testValid(): void
    {
        // @phpstan-ignore-next-line
        $this->astronautRepository->findOneBy(['name' => 'toto'])->willReturn(null)->shouldBeCalledTimes(1);
        $this->validator->validate('toto', $this->constraint);
        $this->assertNoViolation();
    }

    public function testInvalid(): void
    {
        // @phpstan-ignore-next-line
        $this->astronautRepository
            ->findOneBy(['name' => 'toto'])
            ->willReturn(new Astronaut([]))
            ->shouldBeCalledTimes(1);
        $this->validator->validate('toto', $this->constraint);
        $this
            ->buildViolation($this->constraint->message)
            ->atPath('[name]')
            ->setInvalidValue('toto')
            ->setParameter('{{ field }}', 'name')
            ->assertRaised()
        ;
    }

    public function testUnexpectedTypeException(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        // phpcs:disable Generic.Files.LineLength.TooLong
        $this->expectExceptionMessage('Expected argument of type "App\Validator\Constraints\UniqueField", "Symfony\Component\Validator\Constraints\NotNull" given');
        $this->validator->validate('toto', new NotNull());
    }
}
