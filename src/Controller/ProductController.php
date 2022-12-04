<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[isGranted('ROLE_USER')]
    #[Route('/product/create', name: 'product_create')]
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, ProductRepository $productRepository): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUser($this->getUser());
            $imageFile = $form->get('picture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        'uploads',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file uploads
                }
                $product->setPicture($newFilename);
            }
            $slug = $slugger->slug($product->getName());
            if (!empty($productRepository->findBySlug($slug)))  {
                $slug = $slug . '-' . $product->getId();
            }
            $product->setSlug($slug);
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('product/create.html.twig', [
            'form' => $form,
        ]);
    }
}
