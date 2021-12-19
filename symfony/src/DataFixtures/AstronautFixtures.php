<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Astronaut;
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
                'planet' => 'hq',
                'email' => 'wilson@eleven-labs.com',
            ],
            'astronaut_2' => [
                'username' => 'rocket raccoon',
                'planet' => 'raccoons-of-asgard',
                'email' => 'rocket-raccoon@eleven-labs.com',
            ],
            'astronaut_3' => [
                'username' => 'daffy duck',
                'planet' => 'duck-invaders',
                'email' => 'daffy-duck@eleven-labs.com',
            ],
            'astronaut_4' => [
                'username' => 'po ping',
                'planet' => 'donut-factory',
                'email' => 'po-ping@eleven-labs.com',
            ],
            'astronaut_5' => [
                'username' => 'chat potté',
                'planet' => 'schizo-cats',
                'email' => 'chat-potte@eleven-labs.com',
            ]
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getAstronauts() as $ref => $data) {
            $data['avatar'] = sprintf('planets/%s.png', $data['planet']);
            $astronaut = new Astronaut($data);

            $manager->persist($astronaut);
            $manager->flush();

            $this->addReference($ref, $astronaut);
        }
    }
}
