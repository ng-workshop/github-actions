<?php

declare(strict_types=1);

namespace App\Tests\Integrations\Handler;

use App\Entity\Astronaut;
use App\Exception\AstronautNotFoundException;
use App\Handler\AstronautAvatarHandler;
use App\Handler\AstronautHandler;
use App\Repository\AstronautRepository;
use App\Validator\AstronautValidator;
use App\Validator\Constraints\AstronautConstraints;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

final class AstronautHandlerTest extends TestCase
{
    use ProphecyTrait;

    private AstronautRepository|ObjectProphecy $astronautRepository;
    private EntityManagerInterface|ObjectProphecy $entityManager;
    private AstronautAvatarHandler|ObjectProphecy $astronautAvatarHandler;
    private AstronautHandler $astronautHandler;

    protected function setUp(): void
    {
        $this->astronautRepository = $this->prophesize(AstronautRepository::class);
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->astronautAvatarHandler = $this->prophesize(AstronautAvatarHandler::class);

        $this->astronautHandler = new AstronautHandler(
            new AstronautValidator(
                new AstronautConstraints(['planet-1' => ['name' => 'planet 1'], 'planet-2' => ['name' => 'planet 2']])
            ),
            $this->astronautRepository->reveal(),
            $this->entityManager->reveal(),
            $this->astronautAvatarHandler->reveal(),
        );
    }

    public function testCreate(): void
    {
        $astronautData = [
            'username' => 'wilson',
            'planet' => 'planet-1',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'tmp_file',
        ];

        // @phpstan-ignore-next-line
        $this->astronautAvatarHandler->update(Argument::type(Astronaut::class))->shouldBeCalledTimes(1);

        // @phpstan-ignore-next-line
        $this->entityManager->persist(Argument::type(Astronaut::class))->willReturn(null)->shouldBeCalledTimes(1);
        // @phpstan-ignore-next-line
        $this->entityManager->flush()->willReturn(null)->shouldBeCalledTimes(1);

        $this->astronautHandler->create($astronautData);
    }

    public function testCreateFail(): void
    {
        $astronautData = [
            'username' => 'wilson',
            'planet' => 'planet-1',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'tmp_file',
        ];

        // @phpstan-ignore-next-line
        $this->astronautAvatarHandler->update(Argument::type(Astronaut::class))->shouldBeCalledTimes(1);

        // @phpstan-ignore-next-line
        $this->entityManager->persist(Argument::type(Astronaut::class))->willReturn(null)->shouldBeCalledTimes(1);
        // @phpstan-ignore-next-line
        $this->entityManager->flush()->willThrow(new \Exception());

        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        // @phpstan-ignore-next-line
        $this->astronautAvatarHandler->delete(Argument::type(Astronaut::class))->shouldBeCalledTimes(1);

        $this->expectException(\Exception::class);
        $this->astronautHandler->create($astronautData);
    }

    public function testReadOne(): void
    {
        $astronautData = [
            'username' => 'wilson',
            'planet' => 'planet-1',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/wilson',
        ];

        $astronaut = new Astronaut($astronautData);

        // @phpstan-ignore-next-line
        $this->astronautRepository->find(1)->willReturn($astronaut)->shouldBeCalledTimes(1);

        $result = $this->astronautHandler->read(1);

        $this->assertEquals($result, $astronaut);
    }

    public function testReadOneNotFound(): void
    {
        $this->expectException(AstronautNotFoundException::class);
        $this->expectExceptionMessage('The astronaut with id "1" is not found');

        // @phpstan-ignore-next-line
        $this->astronautRepository->find(1)->willReturn(null)->shouldBeCalledTimes(1);

        $this->astronautHandler->read(1);
    }

    public function testReadAll(): void
    {
        $astronautData1 = [
            'username' => 'wilson',
            'planet' => 'planet-1',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/wilson',
        ];

        $astronautData2 = [
            'username' => 'rocket raccoons',
            'planet' => 'planet-2',
            'email' => 'rocket-raccoon@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/rocket-raccoon',
        ];

        $astronaut1 = new Astronaut($astronautData1);
        $astronaut2 = new Astronaut($astronautData2);

        // @phpstan-ignore-next-line
        $this->astronautRepository->findAll()->willReturn([$astronaut1, $astronaut2])->shouldBeCalledTimes(1);

        $result = $this->astronautHandler->read();

        $this->assertEquals($result, [$astronaut1, $astronaut2]);
    }

    public function testUpdate(): void
    {
        $astronaut = new Astronaut([
            'username' => 'wilson',
            'planet' => 'planet-1',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/wilson',
        ]);

        $astronautData = [
            'username' => 'rocket raccoons',
            'planet' => 'planet-2',
            'email' => 'rocket-raccoon@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/rocket-raccoon',
        ];

        // @phpstan-ignore-next-line
        $this->astronautRepository->find(1)->willReturn($astronaut)->shouldBeCalledTimes(1);
        // @phpstan-ignore-next-line
        $this->astronautAvatarHandler->update($astronaut)->willReturn(true)->shouldBeCalledTimes(1);
        // @phpstan-ignore-next-line
        $this->astronautAvatarHandler
            ->delete(Argument::type(Astronaut::class)) // @phpstan-ignore-line
            ->willReturn(true)
            ->shouldBeCalledTimes(1);

        $result = $this->astronautHandler->update(1, $astronautData);

        $this->assertEquals($result->username, 'rocket raccoons');
        $this->assertEquals($result->planet, 'planet-2');
        $this->assertEquals($result->email, 'rocket-raccoon@eleven-labs.com');
        $this->assertEquals($result->avatar, 'https://avatar.eleven-labs.com/rocket-raccoon');
    }

    public function testDelete(): void
    {
        $astronaut = new Astronaut([
            'username' => 'wilson',
            'planet' => 'planet-1',
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/wilson',
        ]);

        // @phpstan-ignore-next-line
        $this->astronautRepository->find(1)->willReturn($astronaut)->shouldBeCalledTimes(1);

        // @phpstan-ignore-next-line
        $this->entityManager->remove($astronaut)->willReturn(null)->shouldBeCalledTimes(1);
        // @phpstan-ignore-next-line
        $this->entityManager->flush()->willReturn(null)->shouldBeCalledTimes(1);
        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        // @phpstan-ignore-next-line
        $this->astronautAvatarHandler
            ->delete($astronaut)
            ->willReturn(true)
            ->shouldBeCalledTimes(1);

        $this->astronautHandler->delete(1);
    }
}
