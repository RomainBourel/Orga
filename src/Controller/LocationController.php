<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationFormType;
use App\Repository\LocationRepository;
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

    #[Route('/location/edit/{location}', name: 'location_update')]
    #[Security("is_granted('ROLE_ADMIN') or user == location.getUser()")]
    public function update(Location $location,Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(LocationFormType::class, $location);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('user');
        }
        return $this->renderForm('location/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/location/{location}/principal', name: 'location_update_principal')]
    #[Security("is_granted('ROLE_ADMIN') or user == location.getUser()")]
    public function updatePrincipal(Location $location, EntityManagerInterface $em, LocationRepository $locationRepository): Response
    {
            $location->setPrincipal(true);
            $em->flush();
            return $this->redirectToRoute('user');
    }

    #[Route('/location/{location}/remove', name: 'location_remove')]
    #[Security("is_granted('ROLE_ADMIN') or user == location.getUser()")]
    public function remove(Location $location, EntityManagerInterface $em): Response
    {
        $em->remove($location);
        $em->flush();
        return $this->redirectToRoute('user');
    }
}
