<?php

namespace App\Controller;

use App\Entity\Party;
use App\Form\PartyFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PartyController extends AbstractController
{
    #[Route('/party', name: 'party')]
    public function index(): Response
    {
        return $this->render('party/index.html.twig', [
            'party' => 'PartyController',
        ]);
    }

    #[isGranted('ROLE_ADMIN')]
    #[Route('/party/create', name: 'party_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {

        $party = new Party();

        $form = $this->createForm(PartyFormType::class, $party);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $party->setCreator($this->getUser());
            $em->persist($party);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('party/create.html.twig', [
            'form' => $form,
        ]);
    }

}
