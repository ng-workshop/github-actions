<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ViolationException extends \Exception
{
    public function __construct(public ConstraintViolationListInterface $violations)
    {
        parent::__construct('', 0, null);
    }
}
