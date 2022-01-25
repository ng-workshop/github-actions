<?php

declare(strict_types=1);

namespace App\Tests\Units\Serializer;

use App\Exception\ViolationException;
use App\Serializer\ViolationNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

final class ViolationNormalizerTest extends TestCase
{
    private ViolationNormalizer $violationNormalizer;

    protected function setUp(): void
    {
        $this->violationNormalizer = new ViolationNormalizer();
    }

    public function testNormalizeOneViolation(): void
    {
        $constraintViolation = new ConstraintViolation(
            'Violation message',
            '',
            [],
            '',
            'property_path',
            ''
        );


        $constraintViolationList = new ConstraintViolationList([$constraintViolation]);
        $violationException = new ViolationException($constraintViolationList);

        $normalizedViolations = $this->violationNormalizer->normalize($violationException);

        $this->assertCount(1, $normalizedViolations);
        $this->assertCount(1, $normalizedViolations['error']);
        $this->assertEquals('Violation message', $normalizedViolations['error']['property_path'][0]);
    }

    public function testNormalizeMultiViolations(): void
    {
        $constraintViolation1 = new ConstraintViolation(
            'Violation message 1',
            '',
            [],
            '',
            'property_path_1',
            ''
        );

        $constraintViolation2 = new ConstraintViolation(
            'Violation message 2',
            '',
            [],
            '',
            'property_path_2',
            ''
        );

        $constraintViolationList = new ConstraintViolationList([$constraintViolation1, $constraintViolation2]);
        $violationException = new ViolationException($constraintViolationList);

        $normalizedViolations = $this->violationNormalizer->normalize($violationException);

        $this->assertCount(1, $normalizedViolations);
        $this->assertCount(2, $normalizedViolations['errors']);
        $this->assertEquals('Violation message 1', $normalizedViolations['errors']['property_path_1'][0]);
        $this->assertEquals('Violation message 2', $normalizedViolations['errors']['property_path_2'][0]);
    }

    /**
     * @dataProvider provideSupportsNormalization
     */
    public function testSupportsNormalization(mixed $data, bool $expected): void
    {
        $this->assertEquals($expected, $this->violationNormalizer->supportsNormalization($data));
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    public function provideSupportsNormalization(): array
    {
        return [
            [
                new ViolationException(new ConstraintViolationList([])),
                true,
            ],
            [
                'string',
                false,
            ],
            [
                1,
                false,
            ],
            [
                [],
                false,
            ],
            [
                new \stdClass(),
                false,
            ]
        ];
    }
}
