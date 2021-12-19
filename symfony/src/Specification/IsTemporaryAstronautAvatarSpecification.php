<?php

declare(strict_types=1);

namespace App\Specification;

final class IsTemporaryAstronautAvatarSpecification implements SpecificationInterface
{
    public function isSatisfiedBy(mixed $candidate): bool
    {
        return 1 === preg_match('/^astronaut_avatar_.*$/', $candidate);
    }
}
