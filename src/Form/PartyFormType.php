<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Party;
use App\Entity\Product;
use App\Entity\ProductParty;
use App\Repository\LocationRepository;
use App\Repository\ProductPartyRepository;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
                'query_builder' => function (LocationRepository $qb) {
                    return $qb->createQueryBuilder('l')
                        ->addOrderBy('l.principal', 'DESC',)
                        ->addOrderBy('l.name', 'ASC')
                    ;
                },
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
