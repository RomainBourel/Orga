<?php

namespace App\Form;

use App\Entity\PropositionDate;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class PropositionDateFormType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startingAt', null, [
                'label' => $this->translator->trans('form.proposition_date.label.starting_at'),
                'widget' => 'single_text',
            ])
            ->add('endingAt', null, [
                'label' => $this->translator->trans('form.proposition_date.label.ending_at'),
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('numberMaxParticipant', null, [
                'attr' => ['placeholder' => $this->translator->trans('form.proposition_date.placeholder.number_max_participant')],
                'label' => $this->translator->trans('form.proposition_date.label.number_max_participant'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropositionDate::class,
        ]);
    }
}
