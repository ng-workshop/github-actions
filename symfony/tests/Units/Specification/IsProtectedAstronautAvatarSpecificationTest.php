<?php

declare(strict_types=1);

namespace App\Tests\Units\Specification;

use App\Specification\IsProtectedAstronautAvatarSpecification;
use Monolog\Test\TestCase;

final class IsProtectedAstronautAvatarSpecificationTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testIsSatisfiedBy(string $candidate, bool $expected): void
    {
        $isProtectedAstronautAvatarSpecification = new IsProtectedAstronautAvatarSpecification(
            'planets',
            ['planet-1' => ['name' => 'Planet 1'], 'planet-2' => ['name' => 'Planet 2']]
        );

        $this->assertEquals($expected, $isProtectedAstronautAvatarSpecification->isSatisfiedBy($candidate));
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function provideData(): array
    {
        return [
            [
                'planets/planet-1.png',
                true,
            ],
            [
                'planets/planet-3.png',
                false,
            ]
        ];
    }
}
