<?php

namespace App\Form\DataTransformer;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProductToNumberTransformer implements DataTransformerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * Transforms an object (Product) to a string (productId).
     * @param Product|null $product
     */
    public function transform($product): ?int
    {
        if (null === $product) {
            return null;
        }
        return $product->getId();
    }

    /**
     * Transforms a string (productId) to an object (Product).
     * @param int $productId
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($productId): ?Product
    {
        if (!$productId) {
            return null;
        }
        $product = $this->entityManager->getRepository(Product::class)->find($productId);
        if (null === $product) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $productId
            ));
        }
        return $product;
    }
}