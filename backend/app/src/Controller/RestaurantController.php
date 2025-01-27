<?php

declare(strict_types=1);

namespace App\Controller;

use App\Document\Restaurant;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    private DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    #[Route('/', name: 'restaurant_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {   
        return $this->json(['message' => 'Welcome to the restaurant API!']);
    }

    #[Route('/restaurant/browse', name: 'restaurant_browse', methods: ['GET'])]
    public function browse(): JsonResponse
    {
        $restaurantRepository = $this->dm->getRepository(Restaurant::class);
        $restaurants = $restaurantRepository->findAll();

        // Преобразуем данные в массив
        $data = [];
        foreach ($restaurants as $restaurant) {
            $data[] = [
                'id' => $restaurant->id,
                'name' => $restaurant->name,
                'borough' => $restaurant->borough,
                'cuisine' => $restaurant->cuisine,
            ];
        }

        return $this->json($data);
    }
}
