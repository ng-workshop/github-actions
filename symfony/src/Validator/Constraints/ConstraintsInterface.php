<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

interface ConstraintsInterface
{
    public function getConstraints(bool $partial): Constraint;
}
