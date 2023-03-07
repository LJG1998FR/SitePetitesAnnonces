<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use \DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnnonceFixtures extends BaseFixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [
            //BaseFixtures::class,
            CategorieFixtures::class,
            CoordonneeFixtures::class,
            UtilisateurFixtures::class,
        ];
    }


    private static $annoncesTitres = [
        'Maison à vendre',
        'Appartement à louer',
        'Voiture',
        'Canne à pêche',
        'Adoptez un chat'
    ];

    private static $annoncesDescriptions = [
        'Lorem ipsum dolor sit amet. Sit sunt repudiandae sed maiores enim ut minus deserunt id dolore dolorem qui voluptatem quisquam eos iusto dolorem hic iste sint. Eos neque corporis et aperiam modi vel illo perferendis.
        Est velit corrupti sit maiores delectus sit illo consequatur. Nam Quis modi quo optio eius At corrupti debitis ut voluptas cumque id doloremque quam aut consequuntur repellendus et magnam officia?
        Et incidunt veritatis et exercitationem alias est iusto voluptate et numquam molestiae. Sit nulla minus hic consequatur illo sit vitae deleniti vel reprehenderit esse aut placeat iusto aut nulla ullam.',
        
        'Ut officiis doloribus id internos eveniet et fugit aperiam 33 doloremque natus ut consequuntur consequatur. Ut amet eveniet sit vitae repellat et ipsa voluptatem ut consequuntur sint ut temporibus distinctio.
        Qui omnis ratione id rerum explicabo et omnis illo ut iure dolorum a aperiam vitae. Aut quia accusamus est sequi amet aut nemo dicta. Ut recusandae vitae et velit quis ab nihil enim nam deserunt quas qui beatae eaque sit eaque internos ut nihil laborum.',
        
        'Ut perspiciatis perspiciatis hic amet accusantium id necessitatibus assumenda et provident corporis sit nihil voluptatem in dolorem reiciendis eum quas debitis. Eum minima debitis est galisum blanditiis ut voluptatibus aperiam est quod dolores hic dolorum enim aut similique officia et ipsum quisquam? Ab impedit sequi aut soluta porro est amet natus ex laboriosam possimus est accusantium suscipit et placeat doloribus et fuga doloribus.
        Aut voluptatibus magni qui minima pariatur hic dolor omnis nam dolor suscipit. Et voluptas error est voluptatem facilis aut quidem mollitia ut quas natus aut possimus impedit ut repudiandae beatae.
        Qui dolores odio sed numquam nihil in aliquid minima qui omnis minus eos asperiores magni rem officiis dolore sit laborum excepturi. In assumenda quae aut quis reiciendis hic facere voluptates est officiis fugit. Ea tempore cumque ut earum esse sed voluptatem quia aut illo sunt',
        
        'Lorem ipsum dolor sit amet. Ut rerum libero A atque ut quas ipsam eos quibusdam ducimus aut ipsa beatae aut omnis voluptatum qui dolor ipsam. Ab voluptas fugaaut totam ex quibusdam quisquam. Ab eius soluta Et ducimus quo fugiat magnam est sequi rerum! Aut autem laboriosam aut vero quisquamA accusamus et cumque quasi ut laborum sint id maxime officiis.',
        
        'Lorem ipsum dolor sit amet. Id voluptas repellatSed enim hic dolor voluptatum est numquam vitae sed numquam dolor qui numquam repudiandae. Ut soluta sequi est corporis placeat Et omnis qui quisquam earum ut voluptas placeat cum libero officiis.

        Hic reprehenderit eius eos repellat neque?
        Ut cumque itaque non doloribus similique ea dicta eligendi quo galisum ullam.
        At nihil accusamus et reprehenderit architecto qui commodi veritatis id aperiam tenetur.
        Sed dolorem mollitia aut repellendus necessitatibus nam dolorum alias?'
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Annonce::class, 20, function(Annonce $annonce, $count) {
            $annonce->setTitre($this->faker->randomElement(self::$annoncesTitres));
            $annonce->setDescription($this->faker->randomElement(self::$annoncesDescriptions));
            $annonce->setDatedecreation(new \DateTime());
            $annonce->setPrix(rand(50,500));
            $annonce->setCategorie($this->getReference(Categorie::class . '_' . $this->faker->numberBetween(0, 4)));
            $annonce->setAuteur($this->getReference(Utilisateur::class . '_' . $this->faker->numberBetween(0, 4)));
        });

        $manager->flush();
    }
}
