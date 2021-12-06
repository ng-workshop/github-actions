<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Assert\AvatarAssert;
use App\Validator\Assert\EmailAssert;
use App\Validator\Assert\PlanetAssert;
use App\Validator\Assert\UsernameAssert;

final class AstronautValidator
{
    /**
     * @param array<string ,mixed> $data
     *
     * @return array<string, array<int, string>>
     */
    public function validate(array $data, ?bool $partial = null): array
    {
        $required = !(null === $partial) && !$partial;
        $validator = new Validator();

        return $validator->validate(
            data: $data,
            schema: [
                'username' => new UsernameAssert(
                    value: $data['username'] ?? null,
                    minLength: 5,
                    maxLength: 50,
                    required: $required,
                ),
                'planet' => new PlanetAssert(value: $data['planet'] ?? null, required: $required),
                'email' => new EmailAssert(value: $data['email'] ?? null, required: $required),
                'avatar' => new AvatarAssert(
                    value: $data['avatar'] ?? null,
                    format: '^http(|s):\/\/avatar.eleven-labs.com\/.*',
                    required: $required,
                )
            ],
            allowExtraProperties: false,
        );
    }
}
