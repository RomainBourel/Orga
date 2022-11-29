<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/location', name: 'location')]
    #[Security("is_granted('ROLE_USER')")]
    public function index(): Response
    {
        return $this->render('location/index.html.twig', [
            'location' => $this->getUser()->getLocations(),
        ]);
    }

    #[Route('/location/create', name: 'location_create')]
    #[Security("is_granted('ROLE_USER')")]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $location = new Location();

        $form = $this->createForm(LocationFormType::class, $location);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $location->setUser($this->getUser());
            $em->persist($location);
            $em->flush();
            return $this->redirectToRoute('user');
        }
        return $this->renderForm('location/create.html.twig', [
            'form' => $form,
        ]);
    }

}
