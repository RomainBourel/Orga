<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Contracts\Translation\TranslatorInterface;

class ChangePasswordFormType extends AbstractType
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'label' => $this->translator->trans('form.password.first_label'),
                    'attr' => ['data-principal' => '1'],
                ],
                'second_options' => [
                    'label' => $this->translator->trans('form.password.second_label'),
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'user.password.not_blank',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'user.password.min_length',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/[^a-zA-Z0-9]+/',
                        'message' => 'user.password.regex_sp',
                    ]),
                    new Regex([
                        'pattern' => '/\d+/',
                        'message' => 'user.password.regex_int',
                    ]),
                    new Regex([
                        'pattern' => '/[a-z]+/',
                        'message' => 'user.password.regex_lowercase',
                    ]),
                    new Regex([
                        'pattern' => '/[A-Z]+/',
                        'message' => 'user.password.regex_uppercase',
                    ]),
                ],
                'invalid_message' => 'The password fields must match.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
