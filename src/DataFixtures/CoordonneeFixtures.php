<?php

namespace App\DataFixtures;

use App\Entity\Coordonnee;
use Doctrine\Persistence\ObjectManager;

class CoordonneeFixtures extends BaseFixture
{
    private static $coordonnees = [
        ['Paris', '75056'],
        ['Paris 1', '75101'],
        ['Paris 2', '75102'],
        ['Paris 3', '75103'],
        ['Paris 4', '75104'],
        ['Paris 5', '75105'],
        ['Paris 6', '75106'],
        ['Paris 7', '75107'],
        ['Paris 8', '75108'],
        ['Paris 9', '75109'],
        ['Paris 10', '75110'],
        ['Paris 11', '75111'],
        ['Paris 12', '75112'],
        ['Paris 13', '75113'],
        ['Paris 14', '75114'],
        ['Paris 15', '75115'],
        ['Paris 16', '75116'],
        ['Paris 17', '75117'],
        ['Paris 18', '75118'],
        ['Paris 19', '75119'],
        ['Paris 20', '75120']
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Coordonnee::class, 21, function(Coordonnee $coordonnee, $count) {
            $coordonnee->setVille(self::$coordonnees[$count][0]);
            $coordonnee->setCodepostal(self::$coordonnees[$count][1]);
        });

        $manager->flush();
    }
}
