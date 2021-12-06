<?php

namespace App\Exception;

use Exception;
use Throwable;

class ViolationException extends Exception
{
    /**
     * @param array<string, array<int, string>> $violations
     */
    public function __construct(private array $violations)
    {
        parent::__construct('', 0, null);
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
