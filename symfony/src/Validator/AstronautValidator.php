<?php

declare(strict_types=1);

namespace App\Validator;

use App\Formatter\ArrayToStringFormatter;
use App\Repository\AstronautRepository;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

final class AstronautValidator extends AbstractValidator
{
    /**
     * @param array<string, array<string, mixed>>  $planets
     */
    public function __construct(private array $planets, private AstronautRepository $astronautRepository)
    {
    }

    public function getConstraints(bool $partial): Constraint
    {
        $arrayToStringFormatter = new ArrayToStringFormatter();

        return new Assert\Collection([
            'allowMissingFields' => $partial,
            'allowExtraFields' => false,
            'missingFieldsMessage' => 'The property {{ field }} is missing.',
            'extraFieldsMessage' => 'The property {{ field }} was not expected.',
            'fields' => [
                'username' => [
                    new Assert\NotBlank(
                        message: 'The property "username" should not be blank.',
                    ),
                    new Assert\Type(
                        type: 'string',
                        message: 'The property "username" should be of type {{ type }}.',
                    ),
                    new Assert\Length(
                        min: 5,
                        max: 50,
                        // phpcs:disable Generic.Files.LineLength.TooLong
                        minMessage: 'The property "username" is too short. It should have {{ limit }} characters or more.',
                        // phpcs:disable Generic.Files.LineLength.TooLong
                        maxMessage: 'The property "username" is too long. It should have {{ limit }} characters or less.',
                    ),
                    new AppAssert\UniqueField(repository: $this->astronautRepository),
                ],
                'planet' => [
                    new Assert\NotBlank(
                        message: 'The property "planet" should not be blank.',
                    ),
                    new Assert\Type(
                        type: 'string',
                        message: 'The property "planet" should be of type {{ type }}.',
                    ),
                    new Assert\Choice(
                        choices: array_keys($this->planets),
                        message: sprintf(
                            'The planet you selected is not a valid choice. The possible choices are %s.',
                            $arrayToStringFormatter->format(array_keys($this->planets)),
                        )
                    )
                ],
                'email' => [
                    new Assert\NotBlank(),
                    new Assert\Type(
                        type: 'string',
                        message: 'The property "email" should be of type {{ type }}.',
                    ),
                    new Assert\Email(),
                    new AppAssert\UniqueField(repository: $this->astronautRepository),
                ],
                'avatar' => [
                    new Assert\NotBlank(),
                    new Assert\Type(
                        type: 'string',
                        message: 'The property "avatar" should be of type {{ type }}.',
                    ),
                ],
            ],
        ]);
    }
}
