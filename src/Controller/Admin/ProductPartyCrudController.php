<?php

namespace App\Controller\Admin;

use App\Entity\ProductParty;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
