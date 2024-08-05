<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/categories')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): JsonResponse
    {
        return $this->json(
            $categoryRepository->findAll(),
            context: [
                'groups' => 'categories_list'
            ]
        );
    }
    #[Route('', name: 'api_categories_create', methods: 'POST')]
    public function create(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();
        $category = $serializer->deserialize($data, Category::class, 'json');

        $violations = $validator->validate($category);

        if ($violations->count() > 0) {
            return $this->json([
                'message' => 'Invalid data',
            ], Response::HTTP_BAD_REQUEST);
        }

        $em->persist($category);
        $em->flush();

        return $this->json($category, Response::HTTP_CREATED, context: ['groups' => 'category_item']);
    }
}
