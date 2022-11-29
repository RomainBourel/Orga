<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    #[Security("is_granted('ROLE_USER')")]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
