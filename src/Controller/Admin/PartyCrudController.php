<?php

namespace App\Controller\Admin;

use App\Entity\Party;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PartyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Party::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('description')->hideOnIndex(),
            AssociationField::new('location')->hideWhenUpdating(),
            AssociationField::new('creator')->hideWhenUpdating(),
            AssociationField::new('users'),
            CollectionField::new('propositionDates')->useEntryCrudForm(PropositionDateCrudController::class),
            CollectionField::new('productsParty')->useEntryCrudForm(ProductPartyCrudController::class),
        ];
    }
}
