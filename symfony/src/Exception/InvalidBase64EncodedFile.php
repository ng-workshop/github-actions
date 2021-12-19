<?php

declare(strict_types=1);

namespace App\Exception;

final class InvalidBase64EncodedFile extends \Exception
{
    public function __construct(public string $fileBase64Encoded)
    {
        parent::__construct('Invalid base64 encoded file. The valid format is "data:[[mime/type]];base64,"');
    }
}
