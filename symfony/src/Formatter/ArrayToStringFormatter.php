<?php

declare(strict_types=1);

namespace App\Formatter;

final class ArrayToStringFormatter
{
    /**
     * @param array<int, string> $data
     */
    public function format(array $data): string
    {
        $countElements = count($data) - 1;
        $formattedString = '';

        foreach ($data as $key => $value) {
            $formattedString .= match ($key) {
                0 =>  $value,
                $countElements => ' and ' . $value,
                default => ', ' . $value,
            };
        }

        return $formattedString;
    }
}
