<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductParty;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPartyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sharing')
            ->add('quantity')
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'disabled' => true,
                'query_builder' => function (ProductRepository $qb) {
                    return $qb->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC')
                        ;
                },
            ])
            ->add('party', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductParty::class,
        ]);
    }
}