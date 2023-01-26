<?php

namespace App\Controller\Admin;

use App\Entity\Unity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UnityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Unity::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('shortname'),
        ];
    }
}
