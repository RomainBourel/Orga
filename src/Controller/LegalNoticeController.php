<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalNoticeController extends AbstractController
{
    #[Route('/legal/notice', name: 'legal_notice')]
    public function index(): Response
    {
        return $this->render('legal_notice/index.html.twig', [
            'controller_name' => 'LegalNoticeController',
        ]);
    }
    #[Route('/agree/therms', name: 'agree_therms')]
    public function agreeTerms(): Response
    {
        return $this->render('legal_notice/agree_therms.html.twig', [
            'controller_name' => 'LegalNoticeController',
        ]);
    }
}
