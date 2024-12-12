<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category/{slug}', name: 'app_category')]
    public function index($slug, CategoryRepository $catagotyRepository): Response
    {
        $category = $catagotyRepository->findOneBySlug($slug);
        // dd($category);

        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
