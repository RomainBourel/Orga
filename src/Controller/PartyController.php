<?php

namespace App\Controller;

use App\Entity\Party;
use App\Form\PartyFormType;
use App\Repository\PartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

class PartyController extends AbstractController
{
    #[isGranted('ROLE_ADMIN')]
    #[Route('/party/create', name: 'party_create')]
    public function create(Request $request, EntityManagerInterface $em, PartyRepository $partyRepository, SluggerInterface $slugger): Response
    {

        $party = new Party();

        $form = $this->createForm(PartyFormType::class, $party);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $partyRepository->findNextSlug($slugger->slug($party->getName()));
            $party->setCreator($this->getUser())
                ->setSlug($slug)
            ;
            $em->persist($party);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('party/create.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/party/{slug}', name: 'party_show')]
    public function show(Party $party): Response
    {
        return $this->render('party/index.html.twig', [
            'party' => $party,
        ]);
    }

}
