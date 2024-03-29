<?php

namespace App\Controller;

use App\Entity\Available;
use App\Entity\PropositionDate;
use App\Repository\AvailableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class PropositionDateController extends AbstractController
{
    public function __construct(
        private AvailableRepository $availableRepository,
        private EntityManagerInterface $em,
        private TranslatorInterface $translator
    )
    {
    }

    #[Route('/proposition/date/available/{id}', name: 'proposition_date_available')]
    public function available(PropositionDate $propositionDate): Response
    {
        $reduce = $propositionDate->getAvailables()->reduce(function(bool $accumulator, Available $value): bool {
            return $accumulator || ($value->getUser() === $this->getUser() && $value->isAvailable());
        }, false);

        return $this->json($this->setAvailable($propositionDate, true));
    }

    #[Route('/proposition/date/unavailable/{id}', name: 'proposition_date_unavailable')]
    public function unavailable(PropositionDate $propositionDate): Response
    {
        return $this->json($this->setAvailable($propositionDate, false));
    }
    private function setAvailable(PropositionDate $propositionDate, bool $isAvailable): array
    {
        if ($available = $this->availableRepository->findOneBy(['user' => $this->getUser(), 'propositionDate' => $propositionDate])) {
            $available->setIsAvailable($isAvailable);
        } else {
            $available = (new Available())
                ->setIsAvailable($isAvailable)
                ->setUser($this->getUser())
                ->setPropositionDate($propositionDate)
            ;
            $this->em->persist($available);
            $propositionDate->addAvailable($available);
        }

        $this->em->flush();

        return [
            'isAvailable' => $isAvailable,
            'flash' => [
                'message'=> $isAvailable ? $this->translator->trans('flash.available') : $this->translator->trans('flash.unavailable'),
                'type' => 'success',
            ],
            'participantText' => $this->translator->trans(
                'calendar.number.participant',
                ['%count%' => $propositionDate->countAvailables()]
            ),
        ];
    }
}
