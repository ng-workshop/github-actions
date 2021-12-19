<?php

declare(strict_types=1);

namespace App\Utils;

use App\Exception\InvalidBase64EncodedFile;

final class Base64ExtensionGetter
{
    /**
     * @throws InvalidBase64EncodedFile
     */
    public function getExtension(string $fileBase64Encoded): string
    {
        if (0 === preg_match('/^data:([a-z\/]+)([a-z]+);base64,.*$/', $fileBase64Encoded)) {
            throw new InvalidBase64EncodedFile($fileBase64Encoded);
        }

        $mimeContentType = mime_content_type($fileBase64Encoded);

        // @phpstan-ignore-next-line
        return explode('/', $mimeContentType)[1];
    }
}
