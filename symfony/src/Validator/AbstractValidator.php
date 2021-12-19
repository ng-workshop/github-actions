<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\ViolationException;
use App\Validator\Constraints\ConstraintsInterface;
use Symfony\Component\Validator\Validation;

abstract class AbstractValidator
{
    public function __construct(private ConstraintsInterface $constraints)
    {
    }

    /**
     * @throws ViolationException
     */
    public function validate(mixed $value, bool $partial): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($value, $this->constraints->getConstraints($partial));

        if (1 <= $violations->count()) {
            throw new ViolationException($violations);
        }
    }
}
