<?php

declare(strict_types=1);

namespace App\Tests\Units\Formatter;

use App\Formatter\ArrayToStringFormatter;
use PHPUnit\Framework\TestCase;

final class ArrayToStringFormatterTest extends TestCase
{
    /**
     * @param array<int, string> $data
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
                ['item_1'],
                'item_1',
            ],
            [
                ['item_1', 'item_2'],
                'item_1 and item_2',
            ],
            [
                ['item_1', 'item_2', 'item_3'],
                'item_1, item_2 and item_3',
            ],
            [
                ['item_1', 'item_2', 'item_3', 'item_4'],
                'item_1, item_2, item_3 and item_4',
            ],
        ];
    }
}
