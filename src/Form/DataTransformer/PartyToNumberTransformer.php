<?php

namespace App\Form\DataTransformer;

use App\Entity\Party;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PartyToNumberTransformer implements DataTransformerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * Transforms an object (Product) to a string (productId).
     * @param Party|null $party
     */
    public function transform(mixed $party): ?string
    {
        if (!is_object($party) || 'Proxies\__CG__\\' . Party::class !== get_class($party)) {
            return '';
        }
        return $party->getId();
    }

    /**
     * Transforms a string (productId) to an object (Product).
     * @param int $partytId
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform(mixed $partyId): ?Party
    {
        if (!is_int($partyId) && !is_string($partyId)) {
            return null;
        }
        $party = $this->entityManager->getRepository(Party::class)->find($partyId);
        if (null === $party) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $partyId
            ));
        }
        return $party;
    }
}