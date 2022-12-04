<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Party;
use App\Repository\LocationRepository;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Party::class,
        ]);
    }
}
