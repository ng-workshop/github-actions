<?php

declare(strict_types=1);

namespace App\Validator\Assert;

interface AssertInterface
{
    public function isValid(): ?string;

    public function isRequired(): bool;
}
