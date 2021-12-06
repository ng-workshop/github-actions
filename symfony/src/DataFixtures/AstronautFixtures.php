<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Astronaut;
use App\Enum\PlanetEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AstronautFixtures extends Fixture
{
    /** @return array<string, array<string, string>> */
    private function getAstronauts(): array
    {
        return [
            'astronaut_1' => [
                'username' => 'wilson',
                'planet' => PlanetEnum::HQ->value, // @phpstan-ignore-line
                'email' => 'wilson@eleven-labs.com',
                'avatar' => 'https://avatar.eleven-labs.com/wilson',
            ],
            'astronaut_2' => [
                'username' => 'rocket raccoon',
                'planet' => PlanetEnum::RACCOONS_OF_ASGARD->value, // @phpstan-ignore-line
                'email' => 'rocket-raccoon@eleven-labs.com',
                'avatar' => 'https://avatar.eleven-labs.com/rocket-raccoon',
            ],
            'astronaut_3' => [
                'username' => 'daffy duck',
                'planet' => PlanetEnum::DUCK_INVADERS->value, // @phpstan-ignore-line
                'email' => 'daffy-duck@eleven-labs.com',
                'avatar' => 'https://avatar.eleven-labs.com/daffy-duck',
            ],
            'astronaut_4' => [
                'username' => 'po ping',
                'planet' => PlanetEnum::DONUT_FACTORY->value, // @phpstan-ignore-line
                'email' => 'po-ping@eleven-labs.com',
                'avatar' => 'https://avatar.eleven-labs.com/po-ping',
            ],
            'astronaut_5' => [
                'username' => 'chat potté',
                'planet' => PlanetEnum::SCHIZO_CATS->value, // @phpstan-ignore-line
                'email' => 'schizo-cats@eleven-labs.com',
                'avatar' => 'https://avatar.eleven-labs.com/schizo-cats',
            ]
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getAstronauts() as $ref => $data) {
            $astronaut = new Astronaut($data);

            $manager->persist($astronaut);
            $manager->flush();

            $this->addReference($ref, $astronaut);
        }
    }
}
