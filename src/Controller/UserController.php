<?php

namespace App\Controller;


use App\Form\ChangePasswordFormType;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserController extends AbstractController
{

    public function __construct(private TranslatorInterface $translator)
    {
    }

    #[Route('/user', name: 'user')]
    #[Security("is_granted('ROLE_USER')")]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/user/edit', name: 'user_edit')]
    #[Security("is_granted('ROLE_USER')")]
    public function edit(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $user = $this->getUser();
        $currentEmail = $user->getEmail();
        $form = $this->createForm(UserFormType::class, $this->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($isMailChanged = $user->getEmail() !== $currentEmail) {
                $user->setIsVerified(false);
            }
            $em->flush();
            if ($isMailChanged) {
                return $this->redirectToRoute('app_send_verify_email', ['email' => $user->getEmail()]);
            }
            $this->addFlash('flash', [
                'message' => $this->translator->trans('flash.user.edit.message'),
                'type' => 'success',
            ]);
            return $this->redirectToRoute('user');
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/user/password/edit', name: 'user_password_edit')]
    #[Security("is_granted('ROLE_USER')")]
    public function passwordEdit(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class, $user, [
            'ask_current_password' => true,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('currentPassword');
            if (!$userPasswordHasher->isPasswordValid($user, $currentPassword->getData())) {
                $currentPassword->addError(new FormError($this->translator->trans('error.password.invalid')));
                return $this->render('reset_password/reset.html.twig', [
                    'resetForm' => $form,
                ]);
            }
            $this->getUser()->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
            $em->flush();
            $this->addFlash('flash', [
                'message' => $this->translator->trans('flash.password.edit.message'),
                'type' => 'success',
            ]);
            return $this->redirectToRoute('user');
        }
        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form,
        ]);
    }
}
