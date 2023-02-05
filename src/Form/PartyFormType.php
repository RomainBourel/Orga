<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Party;
use App\Repository\LocationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class PartyFormType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator, private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => $this->translator->trans('form.party.label.name'),
            ])
            ->add('description', null, [
                'label' => $this->translator->trans('form.party.label.description'),
            ])
            ->add('location', EntityType::class, [
                'label' => $this->translator->trans('form.party.label.location'),
                'class' => Location::class,
                'choice_label' => 'name',
                'query_builder' => function (LocationRepository $qb) {
                    return $qb->createQueryBuilder('l')
                        ->join('l.user', 'u')
                        ->where('u.id = :user')
                        ->setParameter('user', $this->security->getUser()->getId())
                        ->addOrderBy('l.principal', 'DESC',)
                        ->addOrderBy('l.name', 'ASC')
                    ;
                },
            ])
            ->add('propositionDates', CollectionType::class, [
                'entry_type' => PropositionDateFormType::class,
                'label' => false,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('productsParty', CollectionType::class, [

                'entry_type' => ProductPartyFormType::class,
                'label' => false,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('product', CollectionType::class, [
                'mapped' => false,
                'entry_type' => ProductFormType::class,
                'label' => false,
                'allow_add' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Party::class,
        ]);
    }
}
