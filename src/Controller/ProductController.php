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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'code' => 200,
                    'response' => $product->getId(),
                ]);
            }
            return $this->redirectToRoute('home');
        }
        if ($request->isXmlHttpRequest()) {
            return $this->renderForm('product/create_form.html.twig', [
            'form' => $form,
        ]);
        }
        return $this->renderForm('product/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[isGranted('ROLE_USER')]
    #[Route('/product/search', name: 'product_search')]
    public function search(Request $request, EntityManagerInterface $em, ProductRepository $productRepository): Response
    {
        $response = $this->render('product/search_proposition.html.twig', [
            'products' => $productRepository->findWith($request->get('q')),
        ]);

        return $this->json([
            'response' => $response,
        ]);
    }
}
