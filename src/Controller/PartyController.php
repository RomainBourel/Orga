<?php

namespace App\Controller;

use App\Entity\Party;
use App\Entity\PropositionDate;
use App\Form\PartyFormType;
use App\Repository\PartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class PartyController extends AbstractController
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    #[isGranted('ROLE_USER')]
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
            if (1 === count($party->getPropositionDates())) {
                $party->getPropositionDates()[0]->setFinalDate($party);
            }
            $em->persist($party);
            $em->flush();
            return $this->redirectToRoute('party_show', ['slug' => $slug]);
        }
        return $this->renderForm('party/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[isGranted('ROLE_USER')]
    #[Route('/party/remove/{slug}', name: 'party_remove')]
    public function remove(Party $party, EntityManagerInterface $em): Response
    {
        $em->remove($party);
        $em->flush();
        return $this->redirectToRoute('home');
    }
    #[Route('/party/{slug}', name: 'party_show')]
    #[Security("is_granted('ROLE_ADMIN') or user == party.getCreator() or party.getUsers().contains(user)")]
    public function show(Party $party): Response
    {
        return $this->render('party/index.html.twig', [
            'party' => $party,
        ]);
    }

    #[Route('/party/invitation/create/{slug}', name: 'party_invitation_create')]
    #[Security("is_granted('ROLE_ADMIN') or user == party.getCreator()")]
    public function createInvitation(Party $party, Request $request, EntityManagerInterface $em): Response
    {
        $isNew = $request->get('new');
        if (!$party->getInvitationToken() or $isNew) {
            $tokenProvider = $this->container->get('security.csrf.token_manager');
            $token = $tokenProvider->getToken('invitation_token')->getValue();
            $party->setInvitationToken($token);
            $em->flush();
        }
        if ($request->isXmlHttpRequest()) {
            if ($isNew) {
                $response = [
                    'link' => $this->generateUrl('party_invitation', ['invitationToken' => $token ?? $party->getInvitationToken()], UrlGeneratorInterface::ABSOLUTE_URL),
                    'flash' => ['message' => $this->translator->trans('flash.new.link'), 'type' => 'success'],
                ];
            } else {
                $response = [
                    'template' => $this->renderView('party/share_link.html.twig', [
                        'party' => $party,
                    ]),
                    'flash' => ['message' => $this->translator->trans('flash.copy.link'), 'type' => 'success'],
                ];
            }
            return $this->json($response);
        }
        return $this->render('party/share_link.html.twig', [
            'invitationToken' => $party->getInvitationToken(),
        ]);
    }

    #[Route('/party/invitation/{invitationToken}', name: 'party_invitation')]
    public function invitation(Party $party, EntityManagerInterface $em): Response
    {
        if (!$party->getUsers()->contains($this->getUser())) {
            $party->addUser($this->getUser());
            $em->flush();
        }
        return $this->redirectToRoute('party_show', ['slug' => $party->getSlug()]);
    }

    #[Route('/party/date/validation/{id}', name: 'party_date_validation')]
    public function dateValidation(PropositionDate $propositionDate, EntityManagerInterface $em): Response
    {
        $party = $propositionDate->getParty();
        $propositionDate->setFinalDate($party);
        $em->flush();
        return $this->redirectToRoute('party_show', ['slug' => $party->getSlug()]);
    }

}
