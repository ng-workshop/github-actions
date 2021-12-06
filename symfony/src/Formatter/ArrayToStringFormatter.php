<?php

declare(strict_types=1);

namespace App\Formatter;

use InvalidArgumentException;
use UnitEnum;

final class ArrayToStringFormatter implements FormatterInterface
{
    /**
     * @param mixed|array<int, UnitEnum> $data
     */
    public function format(mixed $data): string
    {
        if (!is_array($data) || 0 === count($data)) {
            throw new InvalidArgumentException('The argument data must be an array and not empty');
        }

        $countElements = count($data) - 1;
        $formattedString = '';

        foreach ($data as $key => $datum) {
            if (!$datum instanceof UnitEnum) {
                throw new InvalidArgumentException('The argument data must be an array of \UnitEnum');
            }

            $formattedString .= match ($key) {
                0 =>  $datum->value, // @phpstan-ignore-line
                $countElements => ' and ' . $datum->value, // @phpstan-ignore-line
                default => ', ' . $datum->value, // @phpstan-ignore-line
            };
        }

        return $formattedString;
    }
}
