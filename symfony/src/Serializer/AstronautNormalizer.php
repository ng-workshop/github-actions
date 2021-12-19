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

        if (!is_array($data) || !array_key_exists('avatar', $data)) {
            throw new \InvalidArgumentException('The property avatar is require in Astronaut class.');
        }

        $data['avatar'] = sprintf('%s/%s', $this->cdnUrl, $data['avatar']);
        $data['planet'] = $this->planets[$data['planet']]['name'];

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Astronaut;
    }
}
