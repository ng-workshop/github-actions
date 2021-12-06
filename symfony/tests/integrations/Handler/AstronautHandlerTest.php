<?php

declare(strict_types=1);

namespace App\Tests\integrations\Handler;

use App\Entity\Astronaut;
use App\Enum\PlanetEnum;
use App\Exception\AstronautNotFoundException;
use App\Handler\AstronautHandler;
use App\Repository\AstronautRepository;
use App\Validator\AstronautValidator;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class AstronautHandlerTest extends TestCase
{
    use ProphecyTrait;

    private AstronautRepository|ObjectProphecy $astronautRepository;
    private EntityManagerInterface|ObjectProphecy $entityManager;
    private AstronautHandler $astronautHandler;

    protected function setUp(): void
    {
        $this->astronautRepository = $this->prophesize(AstronautRepository::class);
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->astronautHandler = new AstronautHandler(
            new AstronautValidator(),
            $this->astronautRepository->reveal(),
            $this->entityManager->reveal(),
        );
    }

    public function testCreate(): void
    {
        $astronautData = [
            'username' => 'wilson',
            'planet' => PlanetEnum::HQ->value, // @phpstan-ignore-line
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/wilson',
        ];

        // @phpstan-ignore-next-line
        $this->entityManager->persist(Argument::type(Astronaut::class))->willReturn(null)->shouldBeCalledTimes(1);
        $this->entityManager->flush()->willReturn(null)->shouldBeCalledTimes(1); // @phpstan-ignore-line

        $this->astronautHandler->create($astronautData);
    }

    public function testReadOne(): void
    {
        $astronautData = [
            'username' => 'wilson',
            'planet' => PlanetEnum::HQ->value, // @phpstan-ignore-line
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/wilson',
        ];

        $astronaut = new Astronaut($astronautData);

        $this->astronautRepository->find(1)->willReturn($astronaut)->shouldBeCalledTimes(1); // @phpstan-ignore-line

        $result = $this->astronautHandler->read(1);

        $this->assertEquals($result, $astronaut);
    }

    public function testReadOneNotFound(): void
    {
        $this->expectException(AstronautNotFoundException::class);
        $this->expectExceptionMessage('The astronaut with id "1" is not found');

        $this->astronautRepository->find(1)->willReturn(null)->shouldBeCalledTimes(1); // @phpstan-ignore-line

        $this->astronautHandler->read(1);
    }

    public function testReadAll(): void
    {
        $astronautData1 = [
            'username' => 'wilson',
            'planet' => PlanetEnum::HQ->value, // @phpstan-ignore-line
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/wilson',
        ];

        $astronautData2 = [
            'username' => 'rocket raccoons',
            'planet' => PlanetEnum::RACCOONS_OF_ASGARD->value, // @phpstan-ignore-line
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
            'planet' => PlanetEnum::HQ->value, // @phpstan-ignore-line
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/wilson',
        ]);

        $astronautData = [
            'username' => 'rocket raccoons',
            'planet' => PlanetEnum::RACCOONS_OF_ASGARD->value, // @phpstan-ignore-line
            'email' => 'rocket-raccoon@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/rocket-raccoon',
        ];

        $this->astronautRepository->find(1)->willReturn($astronaut)->shouldBeCalledTimes(1); // @phpstan-ignore-line

        $result = $this->astronautHandler->update(1, $astronautData);

        $this->assertEquals($result->username, 'rocket raccoons');
        $this->assertEquals($result->planet, 'raccoons of asgard');
        $this->assertEquals($result->email, 'rocket-raccoon@eleven-labs.com');
        $this->assertEquals($result->avatar, 'https://avatar.eleven-labs.com/rocket-raccoon');
    }

    public function testDelete(): void
    {
        $astronaut = new Astronaut([
            'username' => 'wilson',
            'planet' => PlanetEnum::HQ->value, // @phpstan-ignore-line
            'email' => 'wilson@eleven-labs.com',
            'avatar' => 'https://avatar.eleven-labs.com/wilson',
        ]);

        $this->astronautRepository->find(1)->willReturn($astronaut)->shouldBeCalledTimes(1); // @phpstan-ignore-line

        $this->entityManager->remove($astronaut)->willReturn(null)->shouldBeCalledTimes(1); // @phpstan-ignore-line
        $this->entityManager->flush()->willReturn(null)->shouldBeCalledTimes(1); // @phpstan-ignore-line

        $this->astronautHandler->delete(1);
    }
}
