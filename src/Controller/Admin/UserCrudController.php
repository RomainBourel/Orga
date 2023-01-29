<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        $showLocation = Action::new('showLocation', 'Voir les localisations', 'fa fa-map-marker-alt')
            ->linkToUrl(function (User $user) use ($adminUrlGenerator) {
                return $adminUrlGenerator->setController(LocationCrudController::class)
                    ->set('filters[user][value]', $user->getId())
                    ->set('filters[user][comparison]', '=')
                    ->generateUrl()
                    ;
            })
        ;

        $showParty = Action::new('showParty', 'Voir les événment', 'fa-solid fa-calendar-days')
            ->linkToUrl(function (User $user) use ($adminUrlGenerator) {
                return $adminUrlGenerator->setController(PartyCrudController::class)
                    ->set('filters[creator][value]', $user->getId())
                    ->set('filters[creator][comparison]', '=')
                    ->generateUrl()
                    ;
            })
        ;

        $showProduct = Action::new('showProduct', 'Voir les produits', 'fa-solid fa-basket-shopping')
            ->linkToUrl(function (User $user) use ($adminUrlGenerator) {
                return $adminUrlGenerator->setController(ProductCrudController::class)
                    ->set('filters[user][value]', $user->getId())
                    ->set('filters[user][comparison]', '=')
                    ->generateUrl()
                    ;
            })
        ;

        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, $showLocation)
            ->add(Crud::PAGE_INDEX, $showParty)
            ->add(Crud::PAGE_INDEX, $showProduct)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            EmailField::new('email'),
            ChoiceField::new('roles')
                ->setChoices([
                    'User' => User::ROLE_USER,
                    'Admin' => User::ROLE_ADMIN,
                ])
                ->allowMultipleChoices(),
            BooleanField::new('isVerified'),

        ];
    }
}
