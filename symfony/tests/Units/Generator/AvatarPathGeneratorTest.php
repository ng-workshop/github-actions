<?php

declare(strict_types=1);

namespace App\Tests\Units\Generator;

use App\Entity\Astronaut;
use App\Exception\GenerateAvatarPathException;
use App\Generator\AvatarPathGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

final class AvatarPathGeneratorTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testGenerate(?string $filename, ?File $file, ?Astronaut $astronaut, string $expected): void
    {
        $avatarPathGenerator = new AvatarPathGenerator('tmp', 'planets', 'astronauts');

        $this->assertEquals($expected, $avatarPathGenerator->generate($filename, $file, $astronaut));
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function provideData(): array
    {
        $fileName = 'tmp.file';

        $astronaut = new Astronaut(
            [
                'username' => 'test',
                'planet' => 'test',
                'email' => 'test@test.com',
                'avatar' => 'test/test.test'
            ]
        );

        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $file = new File(\dirname(__DIR__) . '/../Resources/test.png');

        return [
            [
                'fileName' => $fileName,
                'file' => null,
                'astronaut' => null,
                'expected' => 'tmp/tmp.file',
            ],
            [
                'fileName' => null,
                'file' => null,
                'astronaut' => $astronaut,
                'expected' => 'planets/test.png',
            ],
            [
                'fileName' => null,
                'file' => $file,
                'astronaut' => $astronaut,
                'expected' => 'astronauts/test/avatar.png',
            ]
        ];
    }

    /**
     * @dataProvider provideDataException
     */
    public function testThrowException(?string $filename, ?File $file, ?Astronaut $astronaut): void
    {
        $this->expectException(GenerateAvatarPathException::class);
        $this->expectExceptionMessage('Unable to generate the path for the avatar');

        $avatarPathGenerator = new AvatarPathGenerator('tmp', 'planets', 'astronauts');

        $avatarPathGenerator->generate($filename, $file, $astronaut);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function provideDataException(): array
    {
        $fileName = 'tmp.file';

        $astronaut = new Astronaut(
            [
                'username' => 'test',
                'planet' => 'test',
                'email' => 'test@test.com',
                'avatar' => 'test/test.test'
            ]
        );

        $file = new File(\dirname(__DIR__) . '/../Resources/test.png');

        return [
            [
                'fileName' => null,
                'file' => null,
                'astronaut' => null,
            ],
            [
                'fileName' => null,
                'file' => $file,
                'astronaut' => null,
            ],
            [
                'fileName' => $fileName,
                'file' => $file,
                'astronaut' => null,
            ],
            [
                'fileName' => $fileName,
                'file' => null,
                'astronaut' => $astronaut,
            ],
            [
                'fileName' => $fileName,
                'file' => $file,
                'astronaut' => $astronaut,
            ]
        ];
    }
}
