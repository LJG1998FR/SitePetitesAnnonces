<?php

namespace App\Controller\Admin;

use App\Entity\Coordonnee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CoordonneeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coordonnee::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
