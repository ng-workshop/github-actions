<?php

declare(strict_types=1);

namespace App\Tests\integrations\Validator;

use App\Validator\Assert\AssertInterface;
use App\Validator\Assert\UsernameAssert;
use App\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * @param array<string, string> $data,
     * @param array<string, AssertInterface> $schema
     * @param array<string, array<int, string>> $expectedViolation
     *
     * @dataProvider provideData
     */
    public function testValidate(
        array $data,
        array $schema,
        bool $allowExtraProperties,
        int $expectedCountViolation,
        array $expectedViolation,
    ): void {
        $validator = new Validator();
        $result = $validator->validate($data, $schema, $allowExtraProperties);

        $this->assertCount($expectedCountViolation, $result);
        $this->assertEquals($expectedViolation, $result);
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function provideData(): array
    {
        return [
            [
                [
                    'property_1' => 'value_1',
                    'property_2' => 'value_2',
                ],
                [
                    'property_1' => new UsernameAssert(
                        value: 'value_1',
                        required: true,
                    ),
                ],
                false,
                1,
                [
                    'property_2' => [
                        'The "property_2" property is unexpected',
                    ],
                ],
            ],
            [
                [
                    'property_1' => 'value_1',
                    'property_2' => 'value_2',
                ],
                [
                    'property_1' => new UsernameAssert(
                        value: 'value_1',
                        required: true,
                    ),
                ],
                true,
                0,
                [],
            ],
        ];
    }
}
