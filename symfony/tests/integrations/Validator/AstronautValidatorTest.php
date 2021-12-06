<?php

declare(strict_types=1);

namespace App\Tests\integrations\Validator;

use App\Enum\PlanetEnum;
use App\Validator\AstronautValidator;
use PHPUnit\Framework\TestCase;

class AstronautValidatorTest extends TestCase
{
    /**
     * @param array<string, mixed> $data
     * @param array<string, array<int, string>> $expectedViolation
     *
     * @dataProvider provideData
     */
    public function testValidate(
        array $data,
        bool $partial,
        int $expectedCountViolation,
        array $expectedViolation,
    ): void {
        $astronautValidator = new AstronautValidator();
        $result = $astronautValidator->validate($data, $partial);

        $this->assertCount($expectedCountViolation, $result);
        $this->assertEquals($expectedViolation, $result);
    }

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     *
     * @return array<int, array<int, mixed>>
     */
    public function provideData(): array
    {
        return [
            [
                [
                    'username' => 'wilson',
                    'planet' => PlanetEnum::HQ->value, // @phpstan-ignore-line
                    'email' => 'wilson@eleven-labs.com',
                    'avatar' => 'https://avatar.eleven-labs.com/wilson',
                ],
                false,
                0,
                [],
            ],
            [
                [
                    'username' => 'wilson',
                    'planet' => PlanetEnum::HQ->value, // @phpstan-ignore-line
                    'email' => 'wilson@eleven-labs.com',
                ],
                true,
                0,
                [],
            ],
            [
                [
                    'username' => 'wilson',
                    'planet' => PlanetEnum::HQ->value, // @phpstan-ignore-line
                ],
                true,
                0,
                [],
            ],
            [
                [
                    'username' => '',
                    'planet' => 'space weasels',
                    'email' => '@eleven-labs.com',
                    'avatar' => 'https://avatar.eleven-labs.com',
                ],
                false,
                4,
                [
                    'username' => [
                        'The "username" cannot be null or not empty.',
                    ],
                    'planet' => [
                        // phpcs:disable Generic.Files.LineLength.TooLong
                        'The planet "space weasels" is not allowed. The possible choices are hq, raccoons of asgard, duck invaders, donut factory and schizo cats.',
                    ],
                    'email' => [
                        'The "email" to an invalid email format.',
                    ],
                    'avatar' => [
                        'The "avatar" has invalid format. Use this format "^http(|s):\/\/avatar.eleven-labs.com\/.*".',
                    ],
                ],
            ],
            [
                [
                    'username' => '',
                    'planet' => 'space weasels',
                    'email' => '@eleven-labs.com',
                ],
                true,
                3,
                [
                    'username' => [
                        'The "username" cannot be null or not empty.',
                    ],
                    'planet' => [
                        // phpcs:disable Generic.Files.LineLength.TooLong
                        'The planet "space weasels" is not allowed. The possible choices are hq, raccoons of asgard, duck invaders, donut factory and schizo cats.',
                    ],
                    'email' => [
                        'The "email" to an invalid email format.',
                    ],
                ],
            ],
            [
                [
                    'username' => '',
                    'planet' => 1,
                ],
                true,
                2,
                [
                    'username' => [
                        'The "username" cannot be null or not empty.',
                    ],
                    'planet' => [
                        'The "planet" must be a string.',
                    ],
                ],
            ],
            [
                [
                ],
                false,
                4,
                [
                    'username' => [
                        'The "username" property is not defined but is required',
                    ],
                    'planet' => [
                        'The "planet" property is not defined but is required',
                    ],
                    'email' => [
                        'The "email" property is not defined but is required',
                    ],
                    'avatar' => [
                        'The "avatar" property is not defined but is required',
                    ],
                ],
            ],
        ];
    }
}
