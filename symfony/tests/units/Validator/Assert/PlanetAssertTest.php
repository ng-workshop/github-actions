<?php

declare(strict_types=1);

namespace App\Tests\units\Validator\Assert;

use App\Validator\Assert\PlanetAssert;
use PHPUnit\Framework\TestCase;

class PlanetAssertTest extends TestCase
{
    /**
     * @dataProvider provideValidData
     */
    public function testIsValid(string $value): void
    {
        $planetAssert = new PlanetAssert($value);
        $this->assertNull($planetAssert->isValid());
    }

    /**
     * @return array<int, array<int, string>>
     */
    protected function provideValidData(): array
    {
        return [
            ['hq'],
            ['raccoons of asgard'],
            ['duck invaders'],
            ['donut factory'],
            ['schizo cats'],
        ];
    }

    /**
     * @dataProvider provideInvalidData
     */
    public function testIsNotValid(mixed $value, string $expectedMessage): void
    {
        $planetAssert = new PlanetAssert($value);
        $this->assertEquals($expectedMessage, $planetAssert->isValid());
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function provideInvalidData(): array
    {
        return [
            [
                null,
                'The "planet" cannot be null or not empty.',
            ],
            [
                '',
                'The "planet" cannot be null or not empty.',
            ],
            [
                1,
                'The "planet" must be a string.',
            ],
            [
                [],
                'The "planet" must be a string.',
            ],
            [
                new \StdClass(),
                'The "planet" must be a string.',
            ],
            [
                'Raccoon Of Asgard',
                // phpcs:disable Generic.Files.LineLength.TooLong
                'The planet "Raccoon Of Asgard" is not allowed. The possible choices are hq, raccoons of asgard, duck invaders, donut factory and schizo cats.',
            ],
            [
                'space weasels',
                // phpcs:disable Generic.Files.LineLength.TooLong
                'The planet "space weasels" is not allowed. The possible choices are hq, raccoons of asgard, duck invaders, donut factory and schizo cats.',
            ],
        ];
    }
}
