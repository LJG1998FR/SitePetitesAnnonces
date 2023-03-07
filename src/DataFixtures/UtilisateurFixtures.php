<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use \DateTime;

class UtilisateurFixtures extends BaseFixture
{

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }

    private static $utilisateursEmails = [
        'test123@gmail.com',
        'test456@gmail.com',
        'test789@gmail.com',
        'root@gmail.com',
        'example@gmail.com'
    ];

    private static $utilisateursPseudo = [
        'test123',
        'test456',
        'test789',
        'root',
        'example'
    ];

    private static $utilisateursPasswords = [
        'test123',
        'test456',
        'test789',
        'root',
        'example'
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Utilisateur::class, 5, function(Utilisateur $utilisateur, $count) {
            $utilisateur->setEmail(self::$utilisateursEmails[$count]);
            $utilisateur->setPseudo(self::$utilisateursPseudo[$count]);
            $utilisateur->setPassword($this->passwordHasher->hashPassword($utilisateur,self::$utilisateursPasswords[$count]));
            $utilisateur->setDatedecreation(new \DateTime());
        });

        $manager->flush();
    }
}
