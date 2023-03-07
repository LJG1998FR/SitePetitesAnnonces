<?php

namespace App\DataFixtures;

use App\Entity\Coordonnee;
use Doctrine\Persistence\ObjectManager;

class CoordonneeFixtures extends BaseFixture
{
    private static $coordonnees = [
        ['Lyon', '69000'],
        ['Lyon 1', '69001'],
        ['Lyon 2', '69002'],
        ['Lyon 3', '69003'],
        ['Lyon 4', '69004'],
        ['Lyon 5', '69005'],
        ['Lyon 6', '69006'],
        ['Lyon 7', '69007'],
        ['Lyon 8', '69008'],
        ['Lyon 9', '69009']
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Coordonnee::class, 10, function(Coordonnee $coordonnee, $count) {
            $coordonnee->setVille(self::$coordonnees[$count][0]);
            $coordonnee->setCodepostal(self::$coordonnees[$count][1]);
        });

        $manager->flush();
    }
}
