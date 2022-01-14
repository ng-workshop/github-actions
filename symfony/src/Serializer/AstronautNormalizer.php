<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Astronaut;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

final class AstronautNormalizer implements ContextAwareNormalizerInterface
{
    /**
     * @param array<string, array<string, mixed>>  $planets
     */
    public function __construct(private string $cdnUrl, private array $planets)
    {
    }

    /**
     * @return array<string, array<string, array<int, string>>>
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $data = (array) $object;

        $data['avatar'] = sprintf('%s/%s', $this->cdnUrl, $data['avatar']);
        $data['formattedPlanetName'] = $this->planets[$data['planet']]['name'];

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Astronaut;
    }
}
