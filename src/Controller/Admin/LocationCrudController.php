<?php

namespace App\Controller\Admin;

use App\Controller\LocationController;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('user')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('user')->hideWhenUpdating(),
            TextField::new('name'),
            TextField::new('address'),
            TextField::new('city'),
            TextField::new('zipCode'),
            BooleanField::new('principal')
                ->setTemplatePath('admin/location/principal.html.twig')
            ,
        ];
    }
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance->isPrincipal()) {
            LocationController::removeActualPrincipal($entityManager->getRepository(Location::class), $entityInstance->getUser());
        }
        parent::persistEntity($entityManager, $entityInstance);
    }
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance->isPrincipal()) {
            LocationController::removeActualPrincipal($entityManager->getRepository(Location::class), $entityInstance->getUser());
        }
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/index', 'admin/location/index.html.twig')
        ;

    }
}
