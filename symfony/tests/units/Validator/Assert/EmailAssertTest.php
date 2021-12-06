<?php

declare(strict_types=1);

namespace App\Tests\units\Validator\Assert;

use App\Validator\Assert\EmailAssert;
use PHPUnit\Framework\TestCase;

class EmailAssertTest extends TestCase
{
    /**
     * @dataProvider provideValidData
     */
    public function testIsValid(string $value): void
    {
        $emailAssert = new EmailAssert($value);
        $this->assertNull($emailAssert->isValid());
    }

    /**
     * @return array<int, array<int, string>>
     */
    protected function provideValidData(): array
    {
        return [
            ['test@test.test'],
        ];
    }

    /**
     * @dataProvider provideInvalidData
     */
    public function testIsNotValid(mixed $value, string $expectedMessage): void
    {
        $emailAssert = new EmailAssert($value);
        $this->assertEquals($expectedMessage, $emailAssert->isValid());
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function provideInvalidData(): array
    {
        return [
            [
                null,
                'The "email" cannot be null or not empty.',
            ],
            [
                '',
                'The "email" cannot be null or not empty.',
            ],
            [
                1,
                'The "email" must be a string.',
            ],
            [
                [],
                'The "email" must be a string.',
            ],
            [
                new \StdClass(),
                'The "email" must be a string.',
            ],
            [
                'test@test',
                'The "email" to an invalid email format.',
            ],
            [
                'test.test',
                'The "email" to an invalid email format.',
            ],
        ];
    }
}
