<?php

declare(strict_types=1);

namespace App\Validator\Assert;

use function is_string;

final class EmailAssert extends AbstractAssert
{
    private const NULL_OR_EMPTY_MESSAGE_VIOLATION = 'The "email" cannot be null or not empty.';
    private const NO_STRING_MESSAGE_VIOLATION = 'The "email" must be a string.';
    private const INVALID_EMAIL_VIOLATION = 'The "email" to an invalid email format.';

    public function isValid(): ?string
    {
        if (null === $this->value || '' === $this->value) {
            return self::NULL_OR_EMPTY_MESSAGE_VIOLATION;
        }

        if (!is_string($this->value)) {
            return self::NO_STRING_MESSAGE_VIOLATION;
        }

        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            return self::INVALID_EMAIL_VIOLATION;
        }

        return null;
    }
}
