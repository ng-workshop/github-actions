<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Exception\ViolationException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

final class ViolationNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        $formattedViolationList = [];

        /** @var ConstraintViolationInterface $violation */
        foreach ($object->violations as $violation) {
            $property = str_replace(['[', ']'], '', $violation->getPropertyPath());
            $formattedViolationList[$property][] = $violation->getMessage();
        }

        $errorMessage = 1 === count($formattedViolationList) ? 'error' : 'errors';

        return [$errorMessage => $formattedViolationList];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof ViolationException;
    }
}
