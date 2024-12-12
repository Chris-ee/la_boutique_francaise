<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{slug}', name: 'app_product')]
    public function index($slug,ProductRepository $productRepository): Response
    {
        // récupérer le produit
        $produit = $productRepository->findOneBySlug($slug);
        // echo gettype($produit);
        // envoyer le l'objet
        return $this->render('product/index.html.twig', [
            'produit' => $produit,
        ]);
    }
}
