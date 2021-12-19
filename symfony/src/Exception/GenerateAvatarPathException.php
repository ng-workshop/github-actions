<?php

declare(strict_types=1);

namespace App\Exception;

final class GenerateAvatarPathException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Unable to generate the path for the avatar', 0, null);
    }
}
