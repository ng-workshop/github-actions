<?php

declare(strict_types=1);

namespace App\Tests\Integrations\Handler;

use App\Entity\Astronaut;
use App\Exception\NoTemporaryAstronautAvatarFileException;
use App\Exception\ViolationException;
use App\Handler\AstronautAvatarHandler;
use League\Flysystem\FilesystemOperator;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class AstronautAvatarHandlerTest extends KernelTestCase
{
    use ProphecyTrait;

    private AstronautAvatarHandler $astronautAvatarHandler;
    private FilesystemOperator $tmpStorage;
    private FilesystemOperator $cdnStorage;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        // @phpstan-ignore-next-line
        $this->tmpStorage = $container->get('tmp.storage');
        // @phpstan-ignore-next-line
        $this->cdnStorage = $container->get('cdn.storage');
        // @phpstan-ignore-next-line
        $this->astronautAvatarHandler = $container->get('App\Handler\AstronautAvatarHandler');
    }

    public function testCreateOnThrowViolationException(): void
    {
        $this->assertCount(0, $this->tmpStorage->listContents('')->toArray());

        $this->expectException(ViolationException::class);

        $this->astronautAvatarHandler->create('data:application/pdf;base64,JVBERi0');

        $this->assertCount(0, $this->tmpStorage->listContents('')->toArray());
    }

    public function testCreate(): void
    {
        $this->assertCount(0, $this->tmpStorage->listContents('')->toArray());

        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $path = \dirname(__DIR__) . '/../Resources/test.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $data = file_get_contents($path);
        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.CryptoFunctions.WarnCryptoFunc
        // @phpstan-ignore-next-line
        $fileBase64Encoded = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $this->astronautAvatarHandler->create($fileBase64Encoded);

        $directoryContent = $this->tmpStorage->listContents('')->toArray();
        $this->assertCount(1, $directoryContent);
        $this->assertStringContainsString('astronaut_avatar_', $directoryContent[0]->path());
    }

    public function testUpdateWhenExceptionIsThrow(): void
    {
        $astronaut = new Astronaut([
            'username' => 'wilson',
            'planet' => 'hd',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'astronaut_avatar_not-exist-file.png'
        ]);

        $this->expectException(NoTemporaryAstronautAvatarFileException::class);
        $this->expectExceptionMessage(
            'There is no temporary file with the name "astronaut_avatar_not-exist-file.png".'
        );

        $this->astronautAvatarHandler->update($astronaut);
    }

    public function testUpdateWhenIsNotTemporaryAstronautAvatar(): void
    {
        $astronaut = new Astronaut([
            'username' => 'wilson',
            'planet' => 'hd',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'astronauts/wilson.png'
        ]);

        $this->expectException(NoTemporaryAstronautAvatarFileException::class);
        $this->expectExceptionMessage(
            'There is no temporary file with the name "astronauts/wilson.png".'
        );

        $this->assertFalse($this->astronautAvatarHandler->update($astronaut));
    }

    public function testUpdate(): void
    {
        $directoryContent = $this->tmpStorage->listContents('')->toArray();

        $this->assertCount(1, $directoryContent);
        $this->assertCount(0, $this->cdnStorage->listContents('astronauts'));

        $astronaut = new Astronaut([
            'username' => 'wilson',
            'planet' => 'hd',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => $directoryContent[0]->path()
        ]);

        $this->assertTrue($this->astronautAvatarHandler->update($astronaut));

        $this->assertCount(0, $this->tmpStorage->listContents('')->toArray());
        $this->assertCount(1, $this->cdnStorage->listContents('astronauts')->toArray());
        $this->assertCount(1, $this->cdnStorage->listContents('astronauts/wilson')->toArray());
        $this->assertTrue($this->cdnStorage->fileExists('astronauts/wilson/avatar.png'));
    }

    public function testDeleteWhenAstronautAvatarIsProtected(): void
    {
        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $data = file_get_contents(\dirname(__DIR__) . '/../Resources/test.png');

        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.CryptoFunctions.WarnCryptoFunc
        // @phpstan-ignore-next-line
        $this->cdnStorage->write('planets/hq.png', base64_encode($data));

        $this->assertCount(1, $this->cdnStorage->listContents('planets'));
        $this->assertTrue($this->cdnStorage->fileExists('planets/hq.png'));

        $astronaut = new Astronaut([
            'username' => 'wilson',
            'planet' => 'hd',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'planets/hq.png'
        ]);

        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $this->assertFalse($this->astronautAvatarHandler->delete($astronaut));
        $this->assertCount(1, $this->cdnStorage->listContents('planets'));
        $this->assertTrue($this->cdnStorage->fileExists('planets/hq.png'));

        $this->cdnStorage->delete('planets/hq.png');
    }

    public function testDeleteWhenAstronautAvatarDoesNotExist(): void
    {
        $astronaut = new Astronaut([
            'username' => 'wilson',
            'planet' => 'hd',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'astronauts/not-exists/avatar.png'
        ]);

        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $this->assertFalse($this->astronautAvatarHandler->delete($astronaut));
    }

    public function testDelete(): void
    {
        $this->assertCount(1, $this->cdnStorage->listContents('astronauts')->toArray());
        $this->assertCount(1, $this->cdnStorage->listContents('astronauts/wilson')->toArray());
        $this->assertTrue($this->cdnStorage->fileExists('astronauts/wilson/avatar.png'));

        $astronaut = new Astronaut([
            'username' => 'wilson',
            'planet' => 'hd',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'astronauts/wilson/avatar.png'
        ]);

        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $this->assertTrue($this->astronautAvatarHandler->delete($astronaut));
        $this->assertCount(1, $this->cdnStorage->listContents('astronauts')->toArray());
        $this->assertCount(0, $this->cdnStorage->listContents('astronauts/wilson')->toArray());
        $this->assertFalse($this->cdnStorage->fileExists('astronauts/wilson/avatar.png'));
    }

    public static function tearDownAfterClass(): void
    {
        self::bootKernel();

        // @phpstan-ignore-next-line
        self::getContainer()->get('tmp.storage')->deleteDirectory('');
        // @phpstan-ignore-next-line
        self::getContainer()->get('cdn.storage')->deleteDirectory('');
    }
}
