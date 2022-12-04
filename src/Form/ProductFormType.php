<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Unity;
use App\Repository\CategoryRepository;
use App\Repository\UnityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('picture', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please uploads a valid image',
                    ]),
                ],
            ])
            ->add('unity', EntityType::class, [
                'class' => Unity::class,
                'choice_label' => 'shortname',
                'query_builder' => function (UnityRepository $qb) {
                    return $qb->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC')
                    ;
                },
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (CategoryRepository $qb) {
                    return $qb->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC')
                    ;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
