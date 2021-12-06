<?php

declare(strict_types=1);

namespace App\Validator\Assert;

use App\Enum\PlanetEnum;
use App\Formatter\ArrayToStringFormatter;

final class PlanetAssert extends AbstractAssert
{
    private const NULL_OR_EMPTY_MESSAGE_VIOLATION = 'The "planet" cannot be null or not empty.';
    private const NO_STRING_MESSAGE_VIOLATION = 'The "planet" must be a string.';
    private const INVALID_NAME_MESSAGE_VIOLATION = 'The planet "%s" is not allowed. The possible choices are %s.';

    public function isValid(): ?string
    {
        if (null === $this->value || '' === $this->value) {
            return self::NULL_OR_EMPTY_MESSAGE_VIOLATION;
        }

        if (!\is_string($this->value)) {
            return self::NO_STRING_MESSAGE_VIOLATION;
        }

        if (null === PlanetEnum::tryFrom($this->value)) { // @phpstan-ignore-line
            $arrayToStringFormatter = new ArrayToStringFormatter();
            return sprintf(
                self::INVALID_NAME_MESSAGE_VIOLATION,
                $this->value,
                $arrayToStringFormatter->format(PlanetEnum::cases()), // @phpstan-ignore-line
            );
        }

        return null;
    }
}
