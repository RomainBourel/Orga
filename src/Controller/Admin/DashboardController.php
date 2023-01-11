<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Location;
use App\Entity\Party;
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
         return $this->redirect($adminUrlGenerator->setController(CategoryCrudController::class)->generateUrl());

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
        yield MenuItem::linkToCrud($this->translator->trans('bo.category'), 'fas fa-thumbtack', Category::class);
        yield MenuItem::linkToCrud($this->translator->trans('bo.location'), 'fas fa-thumbtack', Location::class);
        yield MenuItem::linkToCrud($this->translator->trans('bo.party'), 'fas fa-thumbtack', Party::class);
    }
}
