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
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductController extends AbstractController
{
    public function __construct(private TranslatorInterface $translator)
    {
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
            $slug = $productRepository->findNextSlug($slugger->slug($product->getName()));
            $product->setSlug($slug);
            if ($this->isGranted('ROLE_ADMIN')) {
                $product->setIsPublished(true);
            }
            $em->persist($product);
            $em->flush();
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'code' => 200,
                    'response' => [
                        'id' => $product->getId(),
                        'name' => $product->getName(),
                        'unity' => $product->getUnity()->getName(),
                    ],
                ]);
            }
            return $this->redirectToRoute('home');
        }
        return $this->render('product/create.html.twig', [
            'form' => $form,
            'formType' => 'create',
        ]);
    }

    #[isGranted('ROLE_USER')]
    #[Route('/product/search', name: 'product_search')]
    public function search(Request $request, EntityManagerInterface $em, ProductRepository $productRepository): Response
    {
        if ($id = $request->get('id')) {
            $response = $this->render('product/search_proposition.html.twig', [
                'products' => $productRepository->findById($id),
            ]);
            return $this->json([
                'response' => $response,
            ]);
        }

        $response = $this->render('product/search_proposition.html.twig', [
            'products' => $productRepository->findWith($request->get('q')),
        ]);
        return $this->json([
            'response' => $response,
        ]);
    }

    #[isGranted('ROLE_USER')]
    #[Route('/product/report/{slug}', name: 'product_report')]
    public function report(Product $product, EntityManagerInterface $em): Response
    {
        if ($product->getReporters()->contains($this->getUser())) {
            $product->removeReporter($this->getUser());
            $response = [
                'flash' => [
                    'message'=> $this->translator->trans('flash.product.unreport'),
                    'type' => 'success',
                ],
                'newText' => $this->translator->trans('link.product.report'),
            ];

        } else {
            $product->addReporter($this->getUser());
            $response = [
                'flash' => [
                    'message'=> $this->translator->trans('flash.product.report'),
                    'type' => 'success',
                ],
                'newText' => $this->translator->trans('link.product.unreport'),
            ];
        }
        $em->flush();
        return $this->json($response);
    }

    #[isGranted('ROLE_ADMIN')]
    #[Route('/product/moderate/{slug}', name: 'product_moderate')]
    public function moderate(Product $product, EntityManagerInterface $em): Response
    {
        if ($product->isModerate()) {
            $product->setIsModerate(false);
            $response = [
                'flash' => [
                    'message'=> $this->translator->trans('flash.product.unmoderate'),
                    'type' => 'success',
                ],
                'newText' => $this->translator->trans('link.product.moderate'),
            ];

        } else {
            $product->setIsModerate(true);
            $response = [
                'flash' => [
                    'message'=> $this->translator->trans('flash.product.moderate'),
                    'type' => 'success',
                ],
                'newText' => $this->translator->trans('link.product.unmoderate'),
            ];
        }
        $em->flush();
        return $this->json($response);
    }
}
