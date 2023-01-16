<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if ($this->isGranted('ROLE_USER') && $invitationToken = $session->get('invitationToken')) {
            $session->remove('invitationToken');
            return $this->redirectToRoute('party_invitation', ['invitationToken' => $invitationToken]);
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
