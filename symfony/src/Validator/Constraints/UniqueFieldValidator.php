<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class UniqueFieldValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueField) {
            throw new UnexpectedTypeException($constraint, UniqueField::class);
        }

        $field = str_replace(['[', ']'], '', $this->context->getPropertyPath());
        $result = $constraint->repository->findOneBy([$field => $value]);

        if (null === $result) {
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->setParameter('{{ field }}', $field)
            ->addViolation();
    }
}
