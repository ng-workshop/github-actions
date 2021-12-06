<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

final class AstronautNotFoundException extends Exception
{
    public function __construct(int $id)
    {
        parent::__construct(sprintf('The astronaut with id "%d" is not found', $id));
    }
}
