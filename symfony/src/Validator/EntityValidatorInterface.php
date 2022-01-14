<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

interface EntityValidatorInterface
{
    public function getConstraints(bool $partial): Constraint;
}
