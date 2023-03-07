<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserFormType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        dump($options);
        $builder
            ->add('email', EmailType::class, [
                'label' => $this->translator->trans('form.user.email'),
            ])
            ->add('username', null, [
                'label' => $this->translator->trans('form.user.username'),
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('button.user.edit'),
                'attr' => ['class' => 'btn btn__primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
