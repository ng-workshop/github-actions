<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Exception\ViolationException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

final class ViolationNormalizer implements ContextAwareNormalizerInterface
{
    /**
     * @return array<string, mixed>
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function normalize($object, string $format = null, array $context = []): array
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

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof ViolationException;
    }
}
