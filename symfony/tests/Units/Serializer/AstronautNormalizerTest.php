<?php

declare(strict_types=1);

namespace App\Tests\Units\Serializer;

use App\Entity\Astronaut;
use App\Serializer\AstronautNormalizer;
use PHPUnit\Framework\TestCase;

final class AstronautNormalizerTest extends TestCase
{
    private AstronautNormalizer $astronautNormalizer;

    protected function setUp(): void
    {
        $this->astronautNormalizer = new AstronautNormalizer(
            'http://cdn.test',
            ['planet-1' => ['name' => 'planet 1'], 'planet-2' => ['name' => 'planet 2']]
        );
    }

    public function testNormalize(): void
    {
        $astronaut = new Astronaut([
            'username' => 'test',
            'planet' => 'planet-1',
            'email' => 'test@test.com',
            'avatar' => 'test-1.png',
        ]);

        $normalizedAstronaut = $this->astronautNormalizer->normalize($astronaut);

        $this->assertCount(7, $normalizedAstronaut);
        $this->assertEquals('test', $normalizedAstronaut['username']);
        $this->assertEquals('planet-1', $normalizedAstronaut['planet']);
        $this->assertEquals('planet 1', $normalizedAstronaut['formattedPlanetName']);
        $this->assertEquals('test@test.com', $normalizedAstronaut['email']);
        $this->assertEquals('http://cdn.test/test-1.png', $normalizedAstronaut['avatar']);
        // @phpstan-ignore-next-line
        $this->assertInstanceOf(\DateTimeImmutable::class, $normalizedAstronaut['createdAt']);
        // @phpstan-ignore-next-line
        $this->assertInstanceOf(\DateTime::class, $normalizedAstronaut['updatedAt']);
    }

    /**
     * @dataProvider provideSupportsNormalization
     */
    public function testSupportsNormalization(mixed $data, bool $expected): void
    {
        $this->assertEquals($expected, $this->astronautNormalizer->supportsNormalization($data));
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    public function provideSupportsNormalization(): array
    {
        return [
            [
                new Astronaut([]),
                true,
            ],
            [
                'string',
                false,
            ],
            [
                1,
                false,
            ],
            [
                [],
                false,
            ],
            [
                new \stdClass(),
                false,
            ]
        ];
    }
}
