<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Location;
use App\Entity\Party;
use App\Entity\Product;
use App\Entity\Unity;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Orga');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute($this->translator->trans('bo.return.website'), 'fa fa-home', 'home');
        yield MenuItem::linkToCrud($this->translator->trans('bo.product'), 'fa-solid fa-basket-shopping', Product::class);
        yield MenuItem::linkToCrud($this->translator->trans('bo.category'), 'fas fa-box-open', Category::class);
        yield MenuItem::linkToCrud($this->translator->trans('bo.location'), 'fa-sharp fa-solid fa-location-dot', Location::class);
        yield MenuItem::linkToCrud($this->translator->trans('bo.party'), 'fa-solid fa-calendar-days', Party::class);
        yield MenuItem::linkToCrud($this->translator->trans('bo.unity'), 'fa-solid fa-scale-unbalanced-flip', Unity::class);
        yield MenuItem::linkToCrud($this->translator->trans('bo.user'), 'fa-solid fa-user', User::class);
    }
}
