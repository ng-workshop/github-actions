<?php

declare(strict_types=1);

namespace App\Tests\Units\Specification;

use App\Specification\IsTemporaryAstronautAvatarSpecification;
use PHPUnit\Framework\TestCase;

final class IsTemporaryAstronautAvatarSpecificationTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testIsSatisfiedBy(string $candidate, bool $expected): void
    {
        $isTemporaryAstronautAvatarSpecification = new IsTemporaryAstronautAvatarSpecification();

        $this->assertEquals($expected, $isTemporaryAstronautAvatarSpecification->isSatisfiedBy($candidate));
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function provideData(): array
    {
        return [
            [
                'astronaut_avatar_test-1.png',
                true,
            ],
            [
                'astronauts/wilson/avatar.png',
                false,
            ],

            [
                'planets/hq.png',
                false,
            ]
        ];
    }
}
