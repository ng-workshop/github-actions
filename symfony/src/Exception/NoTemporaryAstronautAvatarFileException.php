<?php

declare(strict_types=1);

namespace App\Exception;

final class NoTemporaryAstronautAvatarFileException extends \Exception
{
    public function __construct(string $filename)
    {
        parent::__construct(sprintf('There is no temporary file with the name "%s".', $filename));
    }
}
