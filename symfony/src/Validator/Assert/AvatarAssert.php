<?php

declare(strict_types=1);

namespace App\Validator\Assert;

use InvalidArgumentException;

final class AvatarAssert extends AbstractAssert
{
    private const NULL_OR_EMPTY_MESSAGE_VIOLATION = 'The "avatar" cannot be null or not empty.';
    private const NO_STRING_MESSAGE_VIOLATION = 'The "avatar" must be a string.';
    private const INVALID_FORMAT_MESSAGE_VIOLATION = 'The "avatar" has invalid format. Use this format "%s".';

    public function __construct(
        protected mixed $value = null,
        protected ?string $format = null,
        protected ?bool $required = null,
    ) {
        parent::__construct($this->value, $this->required);
    }

    public function isValid(): ?string
    {
        if (null === $this->format) {
            throw new InvalidArgumentException('The option "format" is required');
        }

        if (null === $this->value || '' === $this->value) {
            return self::NULL_OR_EMPTY_MESSAGE_VIOLATION;
        }

        if (!\is_string($this->value)) {
            return self::NO_STRING_MESSAGE_VIOLATION;
        }

        if (0 === preg_match('/' . $this->format . '/', $this->value)) {
            return sprintf(self::INVALID_FORMAT_MESSAGE_VIOLATION, $this->format);
        }

        return null;
    }
}
