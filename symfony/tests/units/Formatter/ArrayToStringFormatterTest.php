<?php

declare(strict_types=1);

namespace App\Tests\units\Formatter;

use App\Formatter\ArrayToStringFormatter;
use App\Tests\units\Formatter\Enum\EnumData1;
use App\Tests\units\Formatter\Enum\EnumData2;
use App\Tests\units\Formatter\Enum\EnumData3;
use App\Tests\units\Formatter\Enum\EnumData4;
use PHPUnit\Framework\TestCase;

class ArrayToStringFormatterTest extends TestCase
{
    /**
     * @param array<int, \BackedEnum> $data
     *
     * @dataProvider provideData
     */
    public function testFormat(array $data, string $expected): void
    {
        $arrayToStringFormatter = new ArrayToStringFormatter();
        $result = $arrayToStringFormatter->format($data);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function provideData(): array
    {
        return [
            [
                EnumData1::cases(), // @phpstan-ignore-line
                'item_1',
            ],
            [
                EnumData2::cases(), // @phpstan-ignore-line
                'item_1 and item_2',
            ],
            [
                EnumData3::cases(), // @phpstan-ignore-line
                'item_1, item_2 and item_3',
            ],
            [
                EnumData4::cases(), // @phpstan-ignore-line
                'item_1, item_2, item_3 and item_4',
            ],
        ];
    }

    /**
     * @dataProvider provideExceptionData
     */
    public function testInvalidArgument(mixed $data, string $expectedExceptionMessage): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $arrayToStringFormatter = new ArrayToStringFormatter();
        $arrayToStringFormatter->format($data);
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function provideExceptionData(): array
    {
        return [
            [
                '',
                'The argument data must be an array and not empty',
            ],
            [
                null,
                'The argument data must be an array and not empty',
            ],
            [
                1,
                'The argument data must be an array and not empty',
            ],
            [
                new \StdClass(),
                'The argument data must be an array and not empty',
            ],
            [
                [],
                'The argument data must be an array and not empty',
            ],
            [
                ['foo', 'bar'],
                'The argument data must be an array of \UnitEnum',
            ],
        ];
    }
}
