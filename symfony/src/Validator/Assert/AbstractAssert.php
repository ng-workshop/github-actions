<?php

declare(strict_types=1);

namespace App\Validator\Assert;

abstract class AbstractAssert implements AssertInterface
{
    public function __construct(protected mixed $value = null, protected ?bool $required = null)
    {
    }

    public function isRequired(): bool
    {
        return $this->required ?? false;
    }
}
