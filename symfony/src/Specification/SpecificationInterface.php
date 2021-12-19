<?php

declare(strict_types=1);

namespace App\Specification;

interface SpecificationInterface
{
    public function isSatisfiedBy(mixed $candidate): bool;
}
