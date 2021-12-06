<?php

declare(strict_types=1);

namespace App\Tests\units\Validator\Assert;

use App\Validator\Assert\UsernameAssert;
use PHPUnit\Framework\TestCase;

class UsernameAssertTest extends TestCase
{
    /**
     * @dataProvider provideValidData
     */
    public function testIsValid(string $value): void
    {
        $usernameAssert = new UsernameAssert($value, 5, 16);
        $this->assertNull($usernameAssert->isValid());
    }

    /**
     * @return array<int, array<int, string>>
     */
    protected function provideValidData(): array
    {
        return [
            ['wilson'],
            ['rocket raccoons'],
            ['daffy duck'],
            ['po ping'],
            ['chat potté'],
        ];
    }

    /**
     * @dataProvider provideInvalidData
     */
    public function testIsNotValid(mixed $value, string $expectedMessage): void
    {
        $usernameAssert = new UsernameAssert($value, 2, 4);
        $this->assertEquals($expectedMessage, $usernameAssert->isValid());
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function provideInvalidData(): array
    {
        return [
            [
                null,
                'The "username" cannot be null or not empty.',
            ],
            [
                '',
                'The "username" cannot be null or not empty.',
            ],
            [
                1,
                'The "username" must be a string.',
            ],
            [
                [],
                'The "username" must be a string.',
            ],
            [
                new \StdClass(),
                'The "username" must be a string.',
            ],
            [
                'a',
                'the "username" must have a minimum size of 2 characters.',
            ],
            [
                'ab',
                'the "username" must have a minimum size of 2 characters.',
            ],
            [
                'abcd',
                'the "username" must have a maximum size of 4 characters.',
            ],
            [
                'abcde',
                'the "username" must have a maximum size of 4 characters.',
            ],
        ];
    }
}
