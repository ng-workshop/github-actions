<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Assert\AssertInterface;

final class Validator
{
    /**
     * @param array<string ,mixed> $data
     * @param array<string, AssertInterface> $schema
     *
     * @return array<string, array<int, string>>
     */
    public function validate(
        array $data,
        array $schema,
        bool $allowExtraProperties,
    ): array {
        $violations = [];

        foreach ($schema as $propertyName => $propertyAssert) {
            if (!array_key_exists($propertyName, $data) && true === $propertyAssert->isRequired()) {
                $violations[$propertyName][] = sprintf(
                    'The "%s" property is not defined but is required',
                    $propertyName
                );

                continue;
            }

            if (array_key_exists($propertyName, $data)) {
                $violation = $propertyAssert->isValid();

                if (null !== $violation) {
                    $violations[$propertyName][] = $violation;
                }
            }
        }

        if (false === $allowExtraProperties) {
            $unexpectedProperties = array_diff_key($data, $schema);

            foreach (array_keys($unexpectedProperties) as $unexpectedProperty) {
                $violations[$unexpectedProperty][] = sprintf(
                    'The "%s" property is unexpected',
                    $unexpectedProperty
                );
            }
        }

        return $violations;
    }
}
