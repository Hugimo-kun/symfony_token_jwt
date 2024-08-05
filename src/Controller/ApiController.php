<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/articles', name: 'api_articles')]
    public function articles(ArticleRepository $articleRepository): JsonResponse
    {
        return $this->json(
            $articleRepository->findAll(),
            context: ['groups' => ['articles:read']],
        );
    }

    #[Route('/categories', name: 'api_categories')]
    public function category(CategoryRepository $categoryRepository): JsonResponse
    {
        return $this->json(
            $categoryRepository->findAll(),
            context: ['groups' => ['categories:read']],
        );
    }

    #[Route('/articles/{id}', name: 'api_articles_item')]
    public function articleItem(Article $article): JsonResponse
    {
        return $this->json(
            $article,
            context: ['groups' => ['article:read']],
        );
    }
}
