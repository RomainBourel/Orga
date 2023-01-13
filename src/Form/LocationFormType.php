<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class LocationFormType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => $this->translator->trans('form.location.label.name'),
            ])
            ->add('address', null, [
                'label' => $this->translator->trans('form.location.label.address'),
            ])
            ->add('city', null, [
                'label' => $this->translator->trans('form.location.label.city'),
            ])
            ->add('zipCode', null, [
                'label' => $this->translator->trans('form.location.label.zip_code'),
            ])
        ;
        if (null === $options['data']->getId()) {
            $builder->add('principal', null, [
                'label' => $this->translator->trans('form.location.label.principal'),
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
