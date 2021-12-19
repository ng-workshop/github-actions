<?php

declare(strict_types=1);

namespace App\Generator;

use App\Entity\Astronaut;
use App\Exception\GenerateAvatarPathException;
use Symfony\Component\HttpFoundation\File\File;

final class AvatarPathGenerator
{
    public function __construct(
        private string $tmpStorageDir,
        private string $planetsStorageDir,
        private string $astronautsStorageDir,
    ) {
    }

    /**
     * @throws GenerateAvatarPathException
     */
    public function generate(
        ?string $fileName = null,
        ?File $file = null,
        ?Astronaut $astronaut = null
    ): string {
        if (null !== $fileName && null === $file && null === $astronaut) {
            return sprintf('%s/%s', $this->tmpStorageDir, $fileName);
        }

        if (null === $fileName && null === $file && null !== $astronaut) {
            return sprintf('%s/%s.png', $this->planetsStorageDir, $astronaut->planet);
        }

        if (null === $fileName && null !== $file && null !== $astronaut) {
            return sprintf('%s/%s/avatar.%s', $this->astronautsStorageDir, $astronaut->username, $file->getExtension());
        }

        throw new GenerateAvatarPathException();
    }
}
