<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\User;
use App\Form\LocationFormType;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class LocationController extends AbstractController
{
    public function __construct(private LocationRepository $locationRepository, private TranslatorInterface $translator)
    {
    }

    #[Route('/location/create', name: 'location_create')]
    #[Security("is_granted('ROLE_USER')")]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $location = new Location();

        $form = $this->createForm(LocationFormType::class, $location);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($location->isPrincipal()) {
                $this->removeActualPrincipal($this->locationRepository, $this->getUser());
            }
            $location->setUser($this->getUser());
            $em->persist($location);
            $em->flush();
            $this->addFlash('flash', [
                'message' => $this->translator->trans('flash.location.create.message'),
                'type' => 'success',
            ]);
            return $this->redirectToRoute('user');
        }
        return $this->render('location/create.html.twig', [
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
            $this->addFlash('flash', [
                'message' => $this->translator->trans('flash.location.update.message'),
                'type' => 'success',
            ]);
            return $this->redirectToRoute('user');
        }
        return $this->render('location/create.html.twig', [
            'form' => $form,
            'location' => $location,
        ]);
    }

    #[Route('/location/{location}/principal', name: 'location_update_principal')]
    #[Security("is_granted('ROLE_ADMIN') or user == location.getUser()")]
    public function updatePrincipal(Location $location, EntityManagerInterface $em, Request $request): Response
    {
            $location->setPrincipal(true);
            $this->removeActualPrincipal($this->locationRepository, $this->getUser());
            $em->flush();
            if ($request->isXmlHttpRequest()) {
                return $this->json(['message'=> 'résidence principal modifier', 'type' => 'success']);
            }
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

    static function removeActualPrincipal(LocationRepository $locationRepository, ?User $user): void
    {
        if (null === $user) {
            return;
        }
        $locationRepository->findOneBy(['principal' => true, 'user' => $user])
            ?->setPrincipal(false);
    }
}
