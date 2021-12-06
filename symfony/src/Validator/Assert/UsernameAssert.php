<?php

declare(strict_types=1);

namespace App\Validator\Assert;

use function is_string;

final class UsernameAssert extends AbstractAssert
{
    private const NULL_OR_EMPTY_MESSAGE_VIOLATION = 'The "username" cannot be null or not empty.';
    private const NO_STRING_MESSAGE_VIOLATION = 'The "username" must be a string.';
    private const MIN_LENGTH_MESSAGE_VIOLATION = 'the "username" must have a minimum size of %d characters.';
    private const MAX_LENGTH__MESSAGE_VIOLATION = 'the "username" must have a maximum size of %d characters.';

    public function __construct(
        protected mixed $value = null,
        protected int $minLength = 0,
        protected int $maxLength = 100,
        protected ?bool $required = null,
    ) {
        parent::__construct($this->value, $this->required);
    }

    public function isValid(): ?string
    {
        if (null === $this->value || '' === $this->value) {
            return self::NULL_OR_EMPTY_MESSAGE_VIOLATION;
        }

        if (!is_string($this->value)) {
            return self::NO_STRING_MESSAGE_VIOLATION;
        }

        if (strlen($this->value) <= $this->minLength) {
            return sprintf(self::MIN_LENGTH_MESSAGE_VIOLATION, $this->minLength);
        }

        if (strlen($this->value) >= $this->maxLength) {
            return sprintf(self::MAX_LENGTH__MESSAGE_VIOLATION, $this->maxLength);
        }

        return null;
    }
}
