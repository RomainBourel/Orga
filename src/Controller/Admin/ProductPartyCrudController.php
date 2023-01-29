<?php

namespace App\Controller\Admin;

use App\Entity\ProductParty;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class ProductPartyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductParty::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('quantity'),
            AssociationField::new('product'),
        ];
    }
}
