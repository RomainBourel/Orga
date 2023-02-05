<?php

namespace App\Controller;

use App\Entity\Party;
use App\Entity\Product;
use App\Entity\PropositionDate;
use App\Form\PartyFormType;
use App\Form\ProductFormType;
use App\Repository\LocationRepository;
use App\Repository\PartyRepository;
use Doctrine\Common\Collections\Collection;
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
    public function __construct(
        private TranslatorInterface    $translator,
        private EntityManagerInterface $em,
        private PartyRepository        $partyRepository,
        private SluggerInterface       $slugger
    )
    {
    }

    #[isGranted('ROLE_USER')]
    #[Route('/party/create', name: 'party_create')]
    public function create(Request $request, EntityManagerInterface $em, PartyRepository $partyRepository, SluggerInterface $slugger, LocationRepository $locationRepository): Response
    {
        if (!$locationRepository->findOneBy(['user' => $this->getUser()])) {
            $this->addFlash('flash', [
                'message' => $this->translator->trans('flash.party.create.need_location.message'),
                'type' => 'warning',
            ]);
            return $this->redirectToRoute('location_create');
        }

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
            $this->addFlash('flash', [
                'message' => $this->translator->trans('flash.party.create.message'),
                'type' => 'success',
            ]);
            return $this->redirectToRoute('party_show', ['slug' => $slug]);
        }

        $productForm = $this->createForm(ProductFormType::class, (new Product()));
        $formType = 'create';
        $modalContent = $this->render('product/create_form.html.twig', [
            'form' => $productForm,
            'formType' => $formType,
        ]);
        return $this->render('party/create.html.twig', [
            'form' => $form,
            'modalContent' => $modalContent,
            'formType' => $formType,
        ]);
    }

    #[isGranted('ROLE_USER')]
    #[Route('/party/edit/{slug}', name: 'party_edit')]
    public function edit(Party $party, Request $request, EntityManagerInterface $em, PartyRepository $partyRepository, SluggerInterface $slugger, LocationRepository $locationRepository): Response
    {
        if (!$locationRepository->findOneBy(['user' => $this->getUser()])) {
            $this->addFlash('flash', [
                'message' => $this->translator->trans('flash.party.create.need_location.message'),
                'type' => 'warning',
            ]);
            return $this->redirectToRoute('location_create');
        }
        $party = $this->clearPastPropositionDate($party);

        $form = $this->createForm(PartyFormType::class, $party);

        $oldName = $party->getName();
        $oldPropositionDates = $this->collectOldPropositionDates($party);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($oldName !== $party->getName()) {
                $party->setSlug($this->partyRepository->findNextSlug($this->slugger->slug($party->getName())));
            }

            $this->manageUpdatePropositionDate($party, $request->get('party_form')['propositionDates'], $oldPropositionDates);
            $this->removeEmptyProductParty($party);
            $this->addFlash('flash', [
                'message' => $this->translator->trans('flash.party.create.message'),
                'type' => 'success',
            ]);
            $partyRepository->save($party, true);
            return $this->redirectToRoute('party_show', ['slug' => $party->getSlug()]);
        }
        $productForm = $this->createForm(ProductFormType::class, (new Product()));
        $modalContent = $this->renderView('product/create_form.html.twig', [
            'form' => $productForm,
            'formType' => 'create',
        ]);
        return $this->render('party/create.html.twig', [
            'form' => $form,
            'modalContent' => $modalContent,
            'formType' => 'edit',
        ]);
    }

    private function collectOldPropositionDates(Party $party): array
    {
        $oldPropositionDates = [];
        foreach ($party->getPropositionDates() as $propositionDate) {
            $oldPropositionDates[$propositionDate->getId()] = [
                'startingAt' => $propositionDate->getStartingAt(),
                'endingAt' => $propositionDate->getEndingAt(),
            ];
        }
        return $oldPropositionDates;
    }

    private function clearPastPropositionDate(Party $party): Party
    {
        foreach ($party->getPropositionDates() as $propositionDate) {
            if ($propositionDate->getStartingAt() < new \DateTime()) {
                $party->removePropositionDate($propositionDate);
            }
        }
        return  $party;
    }

    private function manageUpdatePropositionDate(Party $party, array $requestPropositionDate, array $oldPropositionDates): void
    {
        $isPropositionDateModify = false;
        foreach ($party->getPropositionDates() as $key => $propositionDate) {
            if (null === $propositionDate->getId()) {
                $isPropositionDateModify = true;
            }
            if (isset($requestPropositionDate[$key]['remove'])) {
                $party->removePropositionDate($propositionDate);
                $isPropositionDateModify = true;
            } else if (
                null !== $propositionDate->getId()  &&
                null !== $oldPropositionDates[$propositionDate->getId()] &&
                (
                    $oldPropositionDates[$propositionDate->getId()]['startingAt'] !== $propositionDate->getStartingAt() ||
                    $oldPropositionDates[$propositionDate->getId()]['endingAt'] !== $propositionDate->getEndingAt()
                )
            ) {
                $propositionDate->getAvailables()->clear();
                if (!$propositionDate->isFinalDate()) {
                    $isPropositionDateModify = true;
                }
            }

        }
        if (1 === count($party->getPropositionDates())) {
            $party->setFinalDate($party->getPropositionDates()[0]);
        }
        if (1 < count($party->getPropositionDates()) && $isPropositionDateModify) {
            $party->setFinalDate();
        }
    }

    private function removeEmptyProductParty(Party $party): void
    {
        foreach ($party->getProductsParty() as $productParty) {
            if ($productParty->getQuantity() === 0) {
                $party->removeProductsParty($productParty);
            }
        }
    }

    #[Security("is_granted('ROLE_ADMIN') or user == party.getCreator()")]
    #[Route('/party/remove/{slug}', name: 'party_remove')]
    public function remove(Party $party, EntityManagerInterface $em): Response
    {
        $em->remove($party);
        $em->flush();
        $this->addFlash('flash', [
            'message' => $this->translator->trans('flash.party.remove.message'),
            'type' => 'success',
        ]);
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
    public function invitation(Party $party, EntityManagerInterface $em, Request $request): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            $request->getSession()->set('invitationToken', $party->getInvitationToken());
            return $this->redirectToRoute('home');
        }
        if (!$party->getUsers()->contains($this->getUser())) {
            $party->addUser($this->getUser());
            $em->flush();
        }
        return $this->redirectToRoute('party_show', ['slug' => $party->getSlug()]);
    }

    #[Route('/party/date/validation/{id}', name: 'party_date_validation')]
    public function dateValidation(PropositionDate $propositionDate, EntityManagerInterface $em): Response
    {
        $party = $propositionDate->getParty()->setFinalDate($propositionDate);
        $em->flush();
        $this->addFlash('flash', [
            'message' => $this->translator->trans('flash.party.date_validation.message'),
            'type' => 'success',
        ]);
        return $this->redirectToRoute('party_show', ['slug' => $party->getSlug()]);
    }

}
