<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Party;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CommentController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator
    )
    {
    }

    #[Route('/comment/create/{id}', name: 'comment_create')]
    #[Security("is_granted('ROLE_ADMIN') or user == party.getCreator() or party.getUsers().contains(user)")]
    public function create(Party $party, Request $request, EntityManagerInterface $em): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);
        dump($comment->getMessage());
        if ("" === $comment->getMessage() || null === $comment->getMessage()) {
            return $this->json([
                'error' => true,
                'flash' => [
                    'message' => $this->translator->trans('flash.comment.error'),
                    'type' => 'error'
                ],
            ], 400);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($this->getUser())
                   ->setParty($party)
            ;
            $em->persist($comment);
            $em->flush();
            if ($request->isXmlHttpRequest()) {
                $commentCard = $this->renderView('comment/card.html.twig', [
                    'comment' => $comment,
                ]);
                return $this->json([
                    'message' => $commentCard,
                    'flash' => ['message' => $this->translator->trans('flash.comment.send'), 'type' => 'success'],
                    'day' => (new \DateTimeImmutable())->format('d/m/Y'),
                ]);
            }
        }

        return $this->render('party/create.html.twig', [
            'form' => $form,
        ]);

    }
}
