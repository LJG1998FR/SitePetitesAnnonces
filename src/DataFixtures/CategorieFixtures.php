<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends BaseFixture
{
    private static $categoriesTitles = [
        'Appartement',
        'Maison',
        'Coworking',
        'Hôtel',
        'Terrain'
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Categorie::class, 5, function(Categorie $categorie, $count) {
            $categorie->setNom(self::$categoriesTitles[$count]);
        });

        $manager->flush();
    }
}
