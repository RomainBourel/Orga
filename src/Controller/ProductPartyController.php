<?php

namespace App\Controller;

use App\Entity\ProductParty;
use App\Entity\ReservedProduct;
use App\Repository\ReservedProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductPartyController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private ReservedProductRepository $reservedProductRepository)
    {
    }

    #[Route('/product/party/reserved/{id}', name: 'product_party_reserved')]
    public function reserved(ProductParty $productParty): Response
    {
        if ($this->reservedProductRepository->findOneBy(['user' => $this->getUser(), 'productParty' => $productParty])) {
            return $this->json([], Response::HTTP_BAD_REQUEST);
        } else {
            $reservedProduct = (new ReservedProduct())
                ->setProductParty($productParty)
                ->setUser($this->getUser())
                ->setQuantityReserved($productParty->getQuantity())
                ->setStatus(ReservedProduct::STATUS_RESERVED)
            ;
            $this->em->persist($reservedProduct);
        }

        $this->em->flush();
        return $this->json([
            'buyButton' => $this->renderView('product_party/_buy_button.html.twig', [
                'reservedProduct' => $productParty->getReservedProductByUser($this->getUser()),
                'product' => $productParty,
            ]),
            'flash' => [
                'message'=> 'Produit réservé',
                'type' => 'success',
            ],
        ]);
    }

    #[Route('/product/party/unreserved/{id}', name: 'product_party_unreserved')]
    public function unreserved(ProductParty $productParty): Response
    {
        $reservedProduct = $this->reservedProductRepository->findOneBy(['user' => $this->getUser(), 'productParty' => $productParty]);
        $this->em->remove($reservedProduct);
        $this->em->flush();
        return $this->json([
            'flash' => [
                'message'=> 'Produit réservé retiré',
                'type' => 'success',
            ],
        ]);
    }

    #[Route('/product/party/buy/{id}', name: 'product_party_buy')]
    public function buy(ReservedProduct $reservedProduct): Response
    {
        $reservedProduct
            ->setQuantityBuy($reservedProduct->getQuantityReserved())
            ->setStatus(ReservedProduct::STATUS_BOUGHT)
        ;
        $this->em->flush();
        return $this->json([
            'flash' => [
                'message'=> 'Produit validé',
                'type' => 'success',
            ],
        ]);
    }

    #[Route('/product/party/unbuy/{id}', name: 'product_party_unbuy')]
    public function unbuy(ReservedProduct $reservedProduct): Response
    {
        $reservedProduct
            ->setQuantityBuy(null)
            ->setStatus(ReservedProduct::STATUS_RESERVED)
        ;
        $this->em->flush();
        return $this->json([
            'flash' => [
                'message'=> 'Produit retiré',
                'type' => 'success',
            ],
        ]);
    }
}
