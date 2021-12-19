<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

final class AstronautAvatarConstraints implements ConstraintsInterface
{
    public function getConstraints(bool $partial): Constraint
    {
        return new Assert\Image(
            maxSize: 150000,
            minWidth: 64,
            maxWidth: 256,
            maxHeight: 256,
            minHeight: 64,
            allowSquare: true,
            allowLandscape: false,
            allowPortrait: false,
        );
    }
}
