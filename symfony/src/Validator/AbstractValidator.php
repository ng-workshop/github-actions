<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\ViolationException;
use Symfony\Component\Validator\Validation;

abstract class AbstractValidator implements EntityValidatorInterface
{
    /**
     * @throws ViolationException
     */
    public function validate(mixed $value, bool $partial): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($value, $this->getConstraints($partial));

        if (0 < $violations->count()) {
            throw new ViolationException($violations);
        }
    }
}
