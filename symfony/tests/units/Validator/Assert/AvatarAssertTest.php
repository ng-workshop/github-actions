<?php

declare(strict_types=1);

namespace App\Tests\units\Validator\Assert;

use App\Validator\Assert\AvatarAssert;
use PHPUnit\Framework\TestCase;

class AvatarAssertTest extends TestCase
{
    /**
     * @dataProvider provideValidData
     */
    public function testIsValid(string $value): void
    {
        $avatarAssert = new AvatarAssert($value, '^http(|s):\/\/hostname.com\/.*');
        $this->assertNull($avatarAssert->isValid());
    }

    /**
     * @return array<int, array<int, string>>
     */
    protected function provideValidData(): array
    {
        return [
            ['https://hostname.com/path'],
            ['https://hostname.com/path'],
        ];
    }

    /**
     * @dataProvider provideInvalidData
     */
    public function testIsNotValid(mixed $value, string $expectedMessage): void
    {
        $avatarAssert = new AvatarAssert($value, '^http(|s):\/\/hostname.com\/.*');
        $this->assertEquals($expectedMessage, $avatarAssert->isValid());
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function provideInvalidData(): array
    {
        return [
            [
                null,
                'The "avatar" cannot be null or not empty.',
            ],
            [
                '',
                'The "avatar" cannot be null or not empty.',
            ],
            [
                1,
                'The "avatar" must be a string.',
            ],
            [
                [],
                'The "avatar" must be a string.',
            ],
            [
                new \StdClass(),
                'The "avatar" must be a string.',
            ],
            [
                'http://invalid-hostname/path',
                'The "avatar" has invalid format. Use this format "^http(|s):\/\/hostname.com\/.*".',
            ],
        ];
    }

    public function testArgsFormatIsRequired(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The option "format" is required');

        $avatarAssert = new AvatarAssert('value');
        $avatarAssert->isValid();
    }
}
