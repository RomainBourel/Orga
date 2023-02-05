<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductParty;
use App\Form\DataTransformer\PartyToNumberTransformer;
use App\Form\DataTransformer\ProductToNumberTransformer;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductPartyFormType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator,
        private ProductToNumberTransformer $productToNumberTransformer,
        private PartyToNumberTransformer $partyToNumberTransformer
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', NumberType::class, [
                'label' => $this->translator->trans('form.product_party.quantity')
            ])
            ->add(
                $builder
                    ->create('product', HiddenType::class)
                    ->addModelTransformer($this->productToNumberTransformer)
            )
            ->add(
                $builder
                    ->create('party', HiddenType::class)
                    ->addModelTransformer($this->partyToNumberTransformer)
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductParty::class,
        ]);
    }
}
