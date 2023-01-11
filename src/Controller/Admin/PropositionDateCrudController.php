<?php

namespace App\Controller\Admin;

use App\Entity\PropositionDate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PropositionDateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PropositionDate::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('startingAt'),
            DateTimeField::new('endingAt'),
        ];
    }
}
