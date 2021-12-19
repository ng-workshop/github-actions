<?php

declare(strict_types=1);

namespace App\Specification;

final class IsProtectedAstronautAvatarSpecification implements SpecificationInterface
{
    /**
     * @param array<string, array<string, mixed>>  $planets
     */
    public function __construct(private string $planetsStorageDir, private array $planets)
    {
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        $regex = sprintf(
            '/^%s$/',
            str_replace(
                '/',
                '\/',
                sprintf(
                    '%s/(%s).png',
                    $this->planetsStorageDir,
                    implode('|', array_keys($this->planets))
                )
            )
        );

        return 0 !== preg_match($regex, $candidate);
    }
}
