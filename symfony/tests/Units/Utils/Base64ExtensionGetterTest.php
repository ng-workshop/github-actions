<?php

declare(strict_types=1);

namespace App\Tests\Units\Utils;

use App\Exception\InvalidBase64EncodedFile;
use App\Utils\Base64ExtensionGetter;
use PHPUnit\Framework\TestCase;

final class Base64ExtensionGetterTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testGetExtensionToBase64Encoded(string $base64encoded, string $expected): void
    {
        $base64ExtensionGetter = new Base64ExtensionGetter();
        $this->assertEquals($expected, $base64ExtensionGetter->getExtension($base64encoded));
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function provideData(): array
    {
        return [
            [
                'data:image/png;base64,iVBORw0KGgoAAAANSUhEUg',
                'png',
            ],
            [
                'data:application/pdf;base64,JVBERi0',
                'pdf',
            ],
        ];
    }

    public function testThrowGetExtensionToBase64EncodedByFormat(): void
    {
        $this->expectException(InvalidBase64EncodedFile::class);
        $this->expectExceptionMessage('Invalid base64 encoded file. The valid format is "data:[[mime/type]];base64,"');

        $base64ExtensionGetter = new Base64ExtensionGetter();
        $base64ExtensionGetter->getExtension('foo');
    }
}
